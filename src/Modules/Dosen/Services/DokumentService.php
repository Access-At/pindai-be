<?php

namespace Modules\Dosen\Services;

use App\Helper\DocumentGenerator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Modules\Dosen\DataTransferObjects\DokumentDto;
use Modules\Dosen\Interfaces\DokumentServiceInterface;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Modules\Dosen\Repositories\PenelitianRepository;
use Illuminate\Support\Str;

class DokumentService implements DokumentServiceInterface
{
    public function download(DokumentDto $request, string $id)
    {
        if ($request->jenis_dokumen == 'surat_pengajuan') {
            $file = self::generatePermohonan($id);
        }

        $pathFile = Storage::disk('public')->path($file);

        return [
            'path' => $pathFile,
            'name' => str_replace('out/', '', $file),
        ];
    }

    protected static function generatePermohonan(string $id)
    {
        $penelitian = PenelitianRepository::getPenelitianById($id);
        $ketua = $penelitian->ketua;
        $name = $ketua->name_with_title ?? $ketua->name;

        // Inisialisasi generator dengan path template
        $generator = new DocumentGenerator('doc/template_surat_pengajuan.docx');

        // Set nilai untuk placeholders di template
        $generator->setValues([
            'title' => strtoupper("Surat Pengajuan Ke PRODI"),
            'prodi' => $ketua->prodi,
            'perihal' => 'Pengajuan Pelaksanaan Penelitian Dosen',
            'ketua.nama' => $name,
            'ketua.nidn' => $ketua->nidn,
            'ketua.prodi' => $ketua->prodi,
            'ketua.jf' => $ketua->job_functional,
            'semester' => $penelitian->semester->label(),
            'tahun_ajaran' => Str::substr($penelitian->tahun_akademik, 0, 4) . '/' . Str::substr($penelitian->tahun_akademik, 4, 4),
            'judul_penelitian' => $penelitian->judul,
            'created_at' => Carbon::now()->locale('id')->isoFormat('D MMMM Y'),
        ]);

        $anggotaTable = $penelitian->anggota->map(function ($anggota) {
            $anggota = $anggota->anggotaPenelitian;
            $label = $anggota->is_leader ? 'Ketua Penelitian' : 'Anggota';

            return [
                $label,
                $anggota->name_with_title ?? $anggota->name,
                $anggota->nidn,
                $anggota->job_functional,
                $anggota->prodi,
            ];
        });

        // Tambahkan tabel ke dalam dokumen
        $generator->addTable(
            ['Susunan Anggota', 'Nama', 'NIDN', 'JAFUNG', 'PRODI'],
            $anggotaTable->toArray()
        );

        // Generate QR code
        $imageContent = QrCode::size(300)->format('png')->generate(
            "Tanda tangan digital: {$name} - " . Carbon::now()->locale('id')->isoFormat('D MMMM Y H:mm'),
        );

        $tempImagePath = storage_path('app/public/out/temp_image.png');
        file_put_contents($tempImagePath, $imageContent);

        $generator->setImageValue('barcode', [
            'path' => $tempImagePath,
            'width' => 50,
            'height' => 50,
            'ratio' => false,
        ]);

        // Simpan dokumen ke lokasi yang diinginkan
        $generator->save(storage_path('app/public/out/surat_pengajuan.docx'));

        return 'out/surat_pengajuan.docx';
    }
}
