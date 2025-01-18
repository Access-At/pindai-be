<?php

namespace Modules\Dosen\Services;

use App\Helper\DocumentGenerator;
use App\Models\Faculty;
use App\Models\Prodi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Modules\Dosen\DataTransferObjects\DokumentDto;
use Modules\Dosen\Interfaces\DokumentServiceInterface;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Modules\Dosen\Repositories\PenelitianRepository;
use Illuminate\Support\Str;

class DokumentService implements DokumentServiceInterface
{
    private const DOCUMENT_TYPES = [
        'surat_pengajuan' => 'generatePermohonan',
        'surat_rekomendasi' => 'generateRekomendasi'
    ];

    public function download(DokumentDto $request, string $id): array
    {
        $method = self::DOCUMENT_TYPES[$request->jenis_dokumen] ?? null;
        if (!$method) {
            throw new \InvalidArgumentException('Invalid document type');
        }

        $file = self::$method($id);
        $pathFile = Storage::disk('public')->path($file);

        return [
            'path' => $pathFile,
            'name' => str_replace('out/', '', $file),
        ];
    }

    protected static function generatePermohonan(string $id): string
    {
        $penelitian = PenelitianRepository::getPenelitianById($id);
        $ketua = $penelitian->ketua;
        $name = $ketua->name_with_title ?? $ketua->name;

        $generator = new DocumentGenerator('doc/template_surat_pengajuan.docx');
        $generator->setValues(self::getPengajuanValues($penelitian, $ketua, $name));

        $anggotaTable = self::generateAnggotaTable($penelitian->anggota);
        $generator->addTable(
            ['Susunan Anggota', 'Nama', 'NIDN', 'JAFUNG', 'PRODI'],
            $anggotaTable->toArray()
        );

        self::addQrCode($generator, $name);
        $nameFile = self::formatNameFile("surat-pengajuan-$penelitian->judul");
        $generator->save(storage_path("app/public/out/$nameFile"));

        return "out/$nameFile";
    }

    protected static function generateRekomendasi(string $id): string
    {
        $penelitian = PenelitianRepository::getPenelitianById($id);
        $ketua = $penelitian->ketua;
        $name = $ketua->name_with_title ?? $ketua->name;

        $fakultasData = self::getFakultasData($ketua->prodi);
        $kaprodi = self::getKaprodi($fakultasData['fakultasId']);

        $generator = new DocumentGenerator('doc/template_surat_rekomendasi.docx');
        $generator->setValues(self::getRekomendasiValues($penelitian, $fakultasData, $kaprodi));

        $anggotaTable = self::generateAnggotaTable($penelitian->anggota, false);
        $generator->addTable(
            ['Susunan Anggota', 'Nama', 'NIDN', 'JAFUNG'],
            $anggotaTable->toArray()
        );

        self::addQrCode($generator, $name);

        $nameFile = self::formatNameFile("surat-rekomendasi-$penelitian->judul");
        $generator->save(storage_path("app/public/out/$nameFile"));

        return "out/$nameFile";
    }

    private static function formatNameFile(string $nameFile): string
    {
        return Str::slug($nameFile, '-') . '.docx';
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
        return [
            'nomor' => $penelitian->kode,
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

    private static function generateAnggotaTable($anggota, $includeProdi = true): \Illuminate\Support\Collection
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

    private static function getFakultasData(string $prodiName): array
    {
        $fakultasId = Prodi::where('name', $prodiName)->first()->faculties_id;
        return [
            'fakultasId' => $fakultasId,
            'fakultas' => Faculty::where('id', $fakultasId)->first()->name
        ];
    }

    private static function getKaprodi(int $fakultasId): User
    {
        return User::kaprodiRole()
            ->whereHas('kaprodi', function ($q) use ($fakultasId) {
                $q->where('faculties_id', $fakultasId);
            })->first();
    }

    private static function formatTahunAjaran(string $tahunAkademik): string
    {
        return Str::substr($tahunAkademik, 0, 4) . '/' . Str::substr($tahunAkademik, 4, 4);
    }

    private static function addQrCode(DocumentGenerator $generator, string $name): void
    {
        $imageContent = QrCode::size(300)->format('png')->generate(
            "Tanda tangan digital: {$name} - " . Carbon::now()->locale('id')->isoFormat('D MMMM Y H:mm')
        );

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
