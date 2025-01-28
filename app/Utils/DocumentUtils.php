<?php

namespace App\Utils;

use Carbon\Carbon;
use App\Models\Penelitian;
use App\Models\Pengabdian;
use Illuminate\Support\Str;
use App\Helper\DocumentGenerator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DocumentUtils
{
    public static function generateDocument(
        string $templatePath,
        array $values,
        string $filename,
        string $category,
        Penelitian|Pengabdian $penelitian
    ): string {
        $generator = new DocumentGenerator($templatePath);

        $values = array_merge($values, [
            'category' => mb_strtoupper($category),
            'category_content' => ucwords($category),
        ]);

        $generator->setValues($values);

        self::addQrCode($generator, $penelitian);
        self::addAnggotaTable($generator, $penelitian->anggota);
        self::addAnggotaList($generator, $penelitian->anggota);

        $nameFile = self::formatNameFile($filename);
        $path = "out/{$nameFile}";
        $generator->save(storage_path("app/public/{$path}"));

        return $path;
    }

    public static function getRekomendasiValues($penelitian, $fakultasData, $kaprodi, $no): array
    {
        return [
            'nomor' => $no,
            // 'perihal' => 'Surat Rekomendasi Pelaksanaan Penelitian Dosen',
            'fakultas' => str_replace('Fakultas', '', $fakultasData['fakultas']),
            'prodi' => $penelitian->ketua->prodi,
            'tahun_ajaran' => DateFormatter::formatTahunAjaran($penelitian->tahun_akademik),
            'semester' => $penelitian->semester->label(),
            'judul_penelitian' => $penelitian->judul,
            'created_at' => Carbon::now()->locale('id')->isoFormat('D MMMM Y'),
            'kaprodi.nama' => $kaprodi->name_with_title ?? $kaprodi->name,
            'kaprodi.nidn' => $kaprodi->nidn,
            'kaprodi.email' => $kaprodi->email,
        ];
    }

    public static function getPengajuanValues($penelitian, $ketua): array
    {
        return [
            'title' => mb_strtoupper('Surat Pengajuan Ke PRODI'),
            'prodi' => $ketua->prodi,
            // 'perihal' => 'Pengajuan Pelaksanaan Penelitian Dosen',
            'ketua.nama' => ($ketua->name_with_title ?? $ketua->name),
            'ketua.nidn' => $ketua->nidn,
            'ketua.prodi' => $ketua->prodi,
            'ketua.jf' => $ketua->job_functional,
            'semester' => $penelitian->semester->label(),
            'tahun_ajaran' => DateFormatter::formatTahunAjaran($penelitian->tahun_akademik),
            'judul_penelitian' => $penelitian->judul,
            'created_at' => Carbon::now()->locale('id')->isoFormat('D MMMM Y'),
        ];
    }

    public static function getCoverValues($penelitian, $fakultasData): array
    {
        return [
            'judul_penelitian' => $penelitian->judul,
            'semester' => $penelitian->semester->label(),
            'tahun_ajaran' => DateFormatter::formatTahunAjaran($penelitian->tahun_akademik),
            'prodi' => $penelitian->ketua->prodi,
            'fakultas' => str_replace('Fakultas', '', $fakultasData['fakultas']),
        ];
    }

    public static function getKontrakValues($penelitian, $no, $dppm, $ketua, $tahun): array
    {
        return [
            'tahun' => $tahun,
            'nomor' => $no,
            'judul_penelitian' => $penelitian->judul,
            'nama_ketua' => $ketua->name_with_title ?? $ketua->name,
            'nidn_ketua' => $ketua->nidn,
            'nama_dppm' => $dppm->name,
            'nidn_dppm' => $dppm->nidn,
            'prodi' => $ketua->prodi,
            'tahun_ajaran' => DateFormatter::formatTahunAjaran($penelitian->tahun_akademik),
            'format_tanggal' => DateFormatter::formatTanggal(date('Y-m-d')),
        ];
    }

    public static function getKeteranganSelesaiValues($penelitian, $no, $dppm, $ketua, $kaprodi): array
    {
        return [
            'nomor' => $no,
            'judul_penelitian' => $penelitian->judul,
            'nama_ketua' => $ketua->name_with_title ?? $ketua->name,
            'nidn_ketua' => $ketua->nidn,
            'prodi_ketua' => $ketua->prodi,
            'jf_ketua' => $ketua->job_functional,
            'nama_dppm' => $dppm->name,
            'nama_kaprodi' => $dppm->nidn,
            'tahun_ajaran' => DateFormatter::formatTahunAjaran($penelitian->tahun_akademik),
            'tanggal' => Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y'),
            'kaprodi.nama' => $kaprodi->name_with_title ?? $kaprodi->name,
        ];
    }

    public static function formatNameFile(string $nameFile): string
    {
        return Str::slug($nameFile, '-') . '.docx';
    }

    private static function addQrCode(DocumentGenerator $generator, Penelitian|Pengabdian $penelitian): void
    {
        $ketua = $penelitian->ketua;
        $name = $ketua->name_with_title ?? $ketua->name;

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

    private static function addAnggotaTable(DocumentGenerator $generator, $anggota, bool $includeProdi = true): void
    {
        $headers = ['Susunan Anggota', 'Nama', 'NIDN', 'JAFUNG'];
        if ($includeProdi) {
            $headers[] = 'PRODI';
        }

        $anggotaTable = self::generateAnggotaTable($anggota, $includeProdi);
        $generator->addTable($headers, $anggotaTable->toArray());
    }

    private static function generateAnggotaList($anggota): array
    {
        return $anggota->map(
            fn ($anggota) => $anggota->anggotaPenelitian->name_with_title ?? $anggota->anggotaPenelitian->name
        )->toArray();
    }

    private static function addAnggotaList(DocumentGenerator $generator, $anggota): void
    {
        $anggotaList = self::generateAnggotaList($anggota);
        $generator->addListItems('tim', $anggotaList);
    }
}
