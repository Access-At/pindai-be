<?php

namespace Modules\Dosen\Services;

use App\Enums\StatusPenelitian;
use App\Helper\DocumentGenerator;
use App\Models\Faculty;
use App\Models\NomorDokumen;
use App\Models\Penelitian;
use App\Models\Prodi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Modules\Dosen\DataTransferObjects\DokumentDto;
use Modules\Dosen\Interfaces\DokumentServiceInterface;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Modules\Dosen\Repositories\PenelitianRepository;
use Illuminate\Support\Str;
use Modules\Dosen\Exceptions\DokumentException;

class DokumentService implements DokumentServiceInterface
{
    private const DOCUMENT_TYPES = [
        'cover' => 'generateCover',
        'surat_pengajuan' => 'generatePermohonan',
        'surat_rekomendasi' => 'generateRekomendasi',
        'proposal' => 'generatePropsal'
    ];

    public function download(DokumentDto $request, string $id): array
    {
        $penelitian = PenelitianRepository::getPenelitianById($id);
        $this->validatePenelitian($penelitian, $request->jenis_dokumen);

        $method = self::DOCUMENT_TYPES[$request->jenis_dokumen] ?? null;
        if (!$method) {
            throw new \InvalidArgumentException('Invalid document type');
        }

        $file = self::$method($penelitian);
        $pathFile = Storage::disk('public')->path($file);

        return [
            'path' => $pathFile,
            'name' => str_replace('out/', '', $file),
        ];
    }

    private function validatePenelitian(?Penelitian $penelitian, string $documentType): void
    {
        if (!$penelitian) {
            throw DokumentException::penelitianNotFound();
        }

        if ($documentType === 'cover' && $this->isPendingOrRejectedByKaprodi($penelitian)) {
            throw DokumentException::penlitianCantDownload("Cover", "{$penelitian->status_dppm->message()} DPPM");
        }

        if ($documentType === 'surat_pengajuan' && $this->isPendingOrRejectedByKaprodi($penelitian)) {
            throw DokumentException::penlitianCantDownload("Surat Pengajuan", "{$penelitian->status_dppm->message()} DPPM");
        }

        if ($documentType === 'surat_rekomendasi' && $this->isPendingOrRejectedByKaprodi($penelitian)) {
            throw DokumentException::penlitianCantDownload("Surat Rekomendasi", "{$penelitian->status_kaprodi->message()} kaprodi");
        }

        if ($documentType === "proposal" && $this->isPendingOrRejectedByKaprodi($penelitian)) {
            throw DokumentException::penlitianCantDownload("Proposal", "{$penelitian->status_kaprodi->message()} kaprodi");
        }
    }

    private function isPendingOrRejectedByDPPM(Penelitian $penelitian): bool
    {
        return in_array($penelitian->status_dppm, [StatusPenelitian::Pending, StatusPenelitian::Reject]);
    }

    private function isPendingOrRejectedByKaprodi(Penelitian $penelitian): bool
    {
        return in_array($penelitian->status_kaprodi, [StatusPenelitian::Pending, StatusPenelitian::Reject]);
    }

    protected static function generateCover($penelitian): string
    {
        $ketua = $penelitian->ketua;
        $fakultasData = self::getFakultasData($ketua->prodi);

        $generator = new DocumentGenerator('doc/template_cover.docx');
        $generator->setValues(self::getCoverValues($penelitian, $fakultasData));

        self::addAnggotaList($generator, $penelitian->anggota);

        return self::saveDocument($generator, "cover-$penelitian->judul");
    }

    protected static function generatePermohonan($penelitian): string
    {
        // $penelitian = PenelitianRepository::getPenelitianById($id);
        $ketua = $penelitian->ketua;
        $name = $ketua->name_with_title ?? $ketua->name;

        $generator = new DocumentGenerator('doc/template_surat_pengajuan.docx');
        $generator->setValues(self::getPengajuanValues($penelitian, $ketua, $name));

        self::addAnggotaTable($generator, $penelitian->anggota);
        self::addQrCode($generator, $name);

        return self::saveDocument($generator, "surat-pengajuan-$penelitian->judul");
    }

    protected static function generateRekomendasi($penelitian): string
    {
        // $penelitian = PenelitianRepository::getPenelitianById($id);
        $ketua = $penelitian->ketua;
        $name = $ketua->name_with_title ?? $ketua->name;

        $fakultasData = self::getFakultasData($ketua->prodi);
        $kaprodi = self::getKaprodi($fakultasData['fakultasId']);

        $generator = new DocumentGenerator('doc/template_surat_rekomendasi.docx');
        $generator->setValues(self::getRekomendasiValues($penelitian, $fakultasData, $kaprodi));
        self::addAnggotaTable($generator, $penelitian->anggota, false);
        self::addQrCode($generator, $name);

        return self::saveDocument($generator, "surat-rekomendasi-$penelitian->judul");
    }

    protected static function generatePropsal($penelitian): string
    {
        $generator = new DocumentGenerator('doc/proposal.docx');
        return self::saveDocument($generator, "proposal-$penelitian->judul");
    }


    private static function addAnggotaTable(DocumentGenerator $generator, $anggota, bool $includeProdi = true): void
    {
        $headers = ['Susunan Anggota', 'Nama', 'NIDN', 'JAFUNG'];
        if ($includeProdi) {
            $headers[] = 'PRODI';
        }

        $anggotaTable = self::generateAnggotaTable($anggota, $includeProdi);
        $generator->addTable($headers, $anggotaTable->toArray());
    }

    private static function addAnggotaList(DocumentGenerator $generator, $anggota): void
    {
        $anggotaList = self::generateAnggotaList($anggota);
        $generator->addListItems('tim', $anggotaList);
    }


    private static function saveDocument($generator, string $filename): string
    {
        $nameFile = self::formatNameFile($filename);
        $path = "out/$nameFile";
        $generator->save(storage_path("app/public/$path"));
        return $path;
    }

    private static function formatNameFile(string $nameFile): string
    {
        return Str::slug($nameFile, '-') . '.docx';
    }

    private static function getCoverValues($penelitian, $fakultasData): array
    {
        return [
            'judul_penelitian' => $penelitian->judul,
            'semester' => $penelitian->semester->label(),
            'tahun_ajaran' => self::formatTahunAjaran($penelitian->tahun_akademik),
            'prodi' => $penelitian->ketua->prodi,
            'fakultas' => str_replace('Fakultas', '', $fakultasData['fakultas']),
        ];
    }

    private static function getPengajuanValues($penelitian, $ketua, $name): array
    {
        return [
            'title' => strtoupper("Surat Pengajuan Ke PRODI"),
            'prodi' => $ketua->prodi,
            'perihal' => 'Pengajuan Pelaksanaan Penelitian Dosen',
            'ketua.nama' => $name,
            'ketua.nidn' => $ketua->nidn,
            'ketua.prodi' => $ketua->prodi,
            'ketua.jf' => $ketua->job_functional,
            'semester' => $penelitian->semester->label(),
            'tahun_ajaran' => self::formatTahunAjaran($penelitian->tahun_akademik),
            'judul_penelitian' => $penelitian->judul,
            'created_at' => Carbon::now()->locale('id')->isoFormat('D MMMM Y'),
        ];
    }

    private static function getRekomendasiValues($penelitian, $fakultasData, $kaprodi): array
    {
        $nomorDokumen = NomorDokumen::where('jenis_dokumen', 'surat_rekomendasi')->first();
        $tahun = date('Y');
        $no = "{$nomorDokumen->nomor}/7/{$nomorDokumen->kode_dokumen}/UPB/$tahun";

        return [
            'nomor' => $no,
            'perihal' => 'Surat Rekomendasi Pelaksanaan Penelitian Dosen',
            'fakultas' => str_replace('Fakultas', '', $fakultasData['fakultas']),
            'prodi' => $penelitian->ketua->prodi,
            'tahun_ajaran' => self::formatTahunAjaran($penelitian->tahun_akademik),
            'semester' => $penelitian->semester->label(),
            'judul_penelitian' => $penelitian->judul,
            'created_at' => Carbon::now()->locale('id')->isoFormat('D MMMM Y'),
            'kaprodi.nama' => $kaprodi->name_with_title ?? $kaprodi->name,
            'kaprodi.nidn' => $kaprodi->nidn,
            'kaprodi.email' => $kaprodi->email,
        ];
    }

    private static function generateAnggotaTable($anggota, bool $includeProdi = true): \Illuminate\Support\Collection
    {
        return $anggota->map(function ($anggota) use ($includeProdi) {
            $anggota = $anggota->anggotaPenelitian;
            $label = $anggota->is_leader ? 'Ketua Penelitian' : 'Anggota';
            $data = [
                $label,
                $anggota->name_with_title ?? $anggota->name,
                $anggota->nidn,
                $anggota->job_functional,
            ];
            if ($includeProdi) {
                $data[] = $anggota->prodi;
            }
            return $data;
        });
    }

    private static function generateAnggotaList($anggota): array
    {
        return $anggota->map(
            fn($anggota) =>
            $anggota->anggotaPenelitian->name_with_title ?? $anggota->anggotaPenelitian->name
        )->toArray();
    }

    private static function getFakultasData(string $prodiName): array
    {
        $prodi = Prodi::where('name', $prodiName)->first();
        $fakultas = Faculty::find($prodi->faculties_id);

        return [
            'fakultasId' => $fakultas->id,
            'fakultas' => $fakultas->name
        ];
    }

    private static function getKaprodi(int $fakultasId): User
    {
        return User::kaprodiRole()
            ->whereHas('kaprodi', fn($q) => $q->where('faculties_id', $fakultasId))
            ->first();
    }

    private static function formatTahunAjaran(string $tahunAkademik): string
    {
        return Str::substr($tahunAkademik, 0, 4) . '/' . Str::substr($tahunAkademik, 4, 4);
    }

    private static function addQrCode(DocumentGenerator $generator, string $name): void
    {
        $timestamp = Carbon::now()->locale('id')->isoFormat('D MMMM Y H:mm');
        $imageContent = QrCode::size(300)
            ->format('png')
            ->generate("Tanda tangan digital: {$name} - {$timestamp}");

        $tempImagePath = storage_path('app/public/out/temp_image.png');
        file_put_contents($tempImagePath, $imageContent);

        $generator->setImageValue('barcode', [
            'path' => $tempImagePath,
            'width' => 50,
            'height' => 50,
            'ratio' => false,
        ]);
    }
}
