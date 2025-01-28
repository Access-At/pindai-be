<?php

namespace Modules\Dosen\Services;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Faculty;
use Illuminate\Support\Str;
use App\Models\NomorDokumen;
use App\Utils\DocumentUtils;
use InvalidArgumentException;
use App\Utils\ValidationUtils;
use Illuminate\Support\Facades\Storage;
use Modules\Dosen\Repositories\PenelitianRepository;
use Modules\Dosen\Repositories\PengabdianRepository;
use Modules\Dosen\Interfaces\DokumentServiceInterface;
use Modules\Dosen\DataTransferObjects\DokumentUploadDto;
use Modules\Dosen\DataTransferObjects\DokumentDownloadDto;

class DokumentService implements DokumentServiceInterface
{
    private const DOCUMENT_TYPES = [
        'cover' => 'generateCover',
        'surat_pengajuan' => 'generatePermohonan',
        'surat_rekomendasi' => 'generateRekomendasi',
        'proposal' => 'generateProposal',
        'kontrak_penelitian' => 'generateKontrak',
        'kontrak_pengabdian' => 'generateKontrak',
        'surat_keterangan_selesai' => 'generateKeteranganSelesai',
    ];

    public function download(DokumentDownloadDto $request, string $id): array
    {
        $penelitian = PenelitianRepository::getPenelitianById($id) ?? PengabdianRepository::getPengabdianById($id);
        ValidationUtils::validatePenelitian($penelitian, $request->jenis_dokumen, $request->category);

        $method = self::DOCUMENT_TYPES[$request->jenis_dokumen] ?? null;
        if ( ! $method) {
            throw new InvalidArgumentException('Invalid document type');
        }

        $file = $this->{$method}($penelitian, $request->category);
        $pathFile = Storage::disk('public')->path($file);

        return [
            'path' => $pathFile,
            'name' => basename($file),
        ];
    }

    public function upload(DokumentUploadDto $request, string $id): string
    {
        $penelitian = PenelitianRepository::getPenelitianById($id) ?? PengabdianRepository::getPengabdianById($id);
        $contentFile = base64_decode($request->file, true);

        $formatJudul = Str::slug($penelitian->judul, '-') . '.pdf';
        $formatDokumen = Str::replace('_', '-', $request->jenis_dokumen);
        $nameFile = "{$formatDokumen}-{$formatJudul}";

        $pathFile = Storage::disk('public')->put(
            "{$request->category}/{$penelitian->kode}/{$nameFile}",
            $contentFile
        );

        return $pathFile;
    }

    private static function getFakultasData(string $prodiName): array
    {
        $prodi = Prodi::where('name', $prodiName)->first();
        $fakultas = Faculty::find($prodi->faculties_id);

        return [
            'fakultasId' => $fakultas->id,
            'fakultas' => $fakultas->name,
        ];
    }

    private static function getKaprodi(int $fakultasId): User
    {
        return User::kaprodiRole()
            ->whereHas('kaprodi', fn ($q) => $q->where('faculties_id', $fakultasId))
            ->first();
    }

    private function generateCover($penelitian, $category): string
    {
        $ketua = $penelitian->ketua;
        $fakultasData = self::getFakultasData($ketua->prodi);

        return DocumentUtils::generateDocument(
            'doc/template_cover.docx',
            DocumentUtils::getCoverValues($penelitian, $fakultasData),
            "cover-{$penelitian->judul}",
            $category,
            $penelitian
        );
    }

    private function generatePermohonan($penelitian, $category): string
    {
        $ketua = $penelitian->ketua;

        return DocumentUtils::generateDocument(
            'doc/template_surat_pengajuan.docx',
            DocumentUtils::getPengajuanValues($penelitian, $ketua),
            "surat-pengajuan-{$penelitian->judul}",
            $category,
            $penelitian
        );
    }

    private function generateRekomendasi($penelitian, $category): string
    {
        $ketua = $penelitian->ketua;
        $fakultasData = self::getFakultasData($ketua->prodi);
        $kaprodi = self::getKaprodi($fakultasData['fakultasId']);

        $nomorDokumen = NomorDokumen::where('jenis_dokumen', 'surat_rekomendasi')->first();
        $tahun = date('Y');
        $no = "{$nomorDokumen->kode_dokumen}{$nomorDokumen->nomor}/7/{$nomorDokumen->kode_dokumen}/UPB/{$tahun}";

        return DocumentUtils::generateDocument(
            'doc/template_surat_rekomendasi.docx',
            DocumentUtils::getRekomendasiValues($penelitian, $fakultasData, $kaprodi, $no),
            "surat-rekomendasi-{$penelitian->judul}",
            $category,
            $penelitian
        );
    }

    private function generateProposal($penelitian, $category): string
    {
        return DocumentUtils::generateDocument(
            'doc/template_proposal.docx',
            [],
            "proposal-{$penelitian->judul}",
            $category,
            $penelitian
        );
    }

    private function generateKontrak($penelitian, $category): string
    {
        $nomorDokumen = NomorDokumen::where('jenis_dokumen', 'surat_rekomendasi')->first();
        $tahun = date('Y');

        $no = "{$nomorDokumen->kode_dokumen}{$nomorDokumen->nomor}/7/{$nomorDokumen->kode_dokumen}/UPB/{$tahun}";
        $dppm = User::DppmRole()->first();
        $ketua = $penelitian->ketua;

        return DocumentUtils::generateDocument(
            'doc/template_kontrak_penelitian.docx',
            DocumentUtils::getKontrakValues($penelitian, $no, $dppm, $ketua, $tahun),
            "kontrak-penelitian-{$penelitian->judul}",
            $category,
            $penelitian
        );
    }

    private function generateKeteranganSelesai($penelitian, $category): string
    {
        $nomorDokumen = NomorDokumen::where('jenis_dokumen', 'surat_keterangan')->first();
        $tahun = date('Y');

        $no = "{$nomorDokumen->kode_dokumen}{$nomorDokumen->nomor}/7/{$nomorDokumen->kode_dokumen}/UPB/{$tahun}";
        $ketua = $penelitian->ketua;

        $dppm = User::DppmRole()->first();
        $fakultasData = self::getFakultasData($ketua->prodi);
        $kaprodi = self::getKaprodi($fakultasData['fakultasId']);

        return DocumentUtils::generateDocument(
            'doc/template_keterangan_selesai.docx',
            DocumentUtils::getKeteranganSelesaiValues($penelitian, $no, $dppm, $ketua, $kaprodi),
            "surat-keterangan-selesai-{$penelitian->judul}",
            $category,
            $penelitian
        );
    }
}
