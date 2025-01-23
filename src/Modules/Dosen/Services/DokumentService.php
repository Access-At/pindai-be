<?php

namespace Modules\Dosen\Services;

use App\Models\Faculty;
use App\Models\NomorDokumen;
use App\Models\Prodi;
use App\Models\User;
use App\Utils\DocumentUtils;
use App\Utils\ValidationUtils;
use Illuminate\Support\Facades\Storage;
use Modules\Dosen\DataTransferObjects\DokumentDto;
use Modules\Dosen\Repositories\PenelitianRepository;
use Modules\Dosen\Interfaces\DokumentServiceInterface;

class DokumentService implements DokumentServiceInterface
{
    private const DOCUMENT_TYPES = [
        'cover' => 'generateCover',
        'surat_pengajuan' => 'generatePermohonan',
        'surat_rekomendasi' => 'generateRekomendasi',
        'proposal' => 'generateProposal',
        'kontrak_penelitian' => 'generateKontrak',
        'surat_keterangan_selesai' => 'generateKeteranganSelesai',
    ];

    public function download(DokumentDto $request, string $id): array
    {
        $penelitian = PenelitianRepository::getPenelitianById($id);
        ValidationUtils::validatePenelitian($penelitian, $request->jenis_dokumen);

        $method = self::DOCUMENT_TYPES[$request->jenis_dokumen] ?? null;
        if (!$method) {
            throw new \InvalidArgumentException('Invalid document type');
        }

        $file = $this->{$method}($penelitian);
        $pathFile = Storage::disk('public')->path($file);

        return [
            'path' => $pathFile,
            'name' => basename($file),
        ];
    }

    private function generateCover($penelitian): string
    {
        $ketua = $penelitian->ketua;
        $fakultasData = self::getFakultasData($ketua->prodi);

        return DocumentUtils::generateDocument(
            'doc/template_cover.docx',
            DocumentUtils::getCoverValues($penelitian, $fakultasData),
            "cover-{$penelitian->judul}"
        );
    }

    private function generatePermohonan($penelitian): string
    {
        $ketua = $penelitian->ketua;

        return DocumentUtils::generateDocument(
            'doc/template_surat_pengajuan.docx',
            DocumentUtils::getPengajuanValues($penelitian, $ketua),
            "surat-pengajuan-{$penelitian->judul}"
        );
    }

    private function generateRekomendasi($penelitian): string
    {
        $ketua = $penelitian->ketua;
        $fakultasData = self::getFakultasData($ketua->prodi);
        $kaprodi = self::getKaprodi($fakultasData['fakultasId']);

        $nomorDokumen = NomorDokumen::where('jenis_dokumen', 'surat_rekomendasi')->first();
        $tahun = date('Y');
        $no = "{$nomorDokumen->kode_dokumen}{$nomorDokumen->nomor}/7/{$nomorDokumen->kode_dokumen}/UPB/$tahun";

        return DocumentUtils::generateDocument(
            'doc/template_surat_rekomendasi.docx',
            DocumentUtils::getRekomendasiValues($penelitian, $fakultasData, $kaprodi, $no),
            "surat-rekomendasi-{$penelitian->judul}"
        );
    }

    private function generateProposal($penelitian): string
    {
        return DocumentUtils::generateDocument(
            'doc/template_proposal.docx',
            [],
            "proposal-{$penelitian->judul}"
        );
    }

    private function generateKontrak($penelitian): string
    {
        $nomorDokumen = NomorDokumen::where('jenis_dokumen', 'surat_rekomendasi')->first();
        $tahun = date('Y');

        $no = "{$nomorDokumen->kode_dokumen}{$nomorDokumen->nomor}/7/{$nomorDokumen->kode_dokumen}/UPB/$tahun";
        $dppm = User::DppmRole()->first();
        $ketua = $penelitian->ketua;

        return DocumentUtils::generateDocument(
            'doc/template_kontrak_penelitian.docx',
            DocumentUtils::getKontrakValues($penelitian, $no, $dppm, $ketua, $tahun),
            "kontrak-penelitian-{$penelitian->judul}"
        );
    }

    private function generateKeteranganSelesai($penelitian): string
    {
        $nomorDokumen = NomorDokumen::where('jenis_dokumen', 'surat_keterangan')->first();
        $tahun = date('Y');

        $no = "{$nomorDokumen->kode_dokumen}{$nomorDokumen->nomor}/7/{$nomorDokumen->kode_dokumen}/UPB/$tahun";
        $ketua = $penelitian->ketua;

        $dppm = User::DppmRole()->first();
        $fakultasData = self::getFakultasData($ketua->prodi);
        $kaprodi = self::getKaprodi($fakultasData['fakultasId']);

        return DocumentUtils::generateDocument(
            'doc/template_keterangan_selesai.docx',
            DocumentUtils::getKeteranganSelesaiValues($penelitian, $no, $dppm, $ketua, $kaprodi),
            "surat-keterangan-selesai-{$penelitian->judul}"
        );
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
}
