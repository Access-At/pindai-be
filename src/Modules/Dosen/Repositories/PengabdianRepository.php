<?php

namespace Modules\Dosen\Repositories;

use App\Models\Pengabdian;
use App\Models\JenisIndeksasi;
use App\Models\JenisPengabdian;
use App\Models\DetailPengabdian;
use App\Models\AnggotaPengabdian;
use Modules\Dosen\DataTransferObjects\PengabdianDto;

class PengabdianRepository
{
    public static function getAllPengabdian()
    {
        return Pengabdian::myPengabdian();
    }

    public static function getPengabdianById($id)
    {
        return Pengabdian::with(['jenisPengabdian', 'jenisIndex', 'detail.anggotaPengabdian'])
            ->byHash($id)
            ->first();
    }

    public static function insertPengabdian(PengabdianDto $request)
    {
        $getJenisPengabdian = JenisPengabdian::byHash($request->jenis_pengabdian)->id;
        $getJenisIndex = JenisIndeksasi::byHash($request->jenis_indeksasi)->id;

        $Pengabdian = Pengabdian::create([
            'tahun_akademik' => $request->tahun_akademik,
            'semester' => $request->semester,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'bidang' => $request->bidang,
            'jenis_pengabdian_id' => $getJenisPengabdian,
            'jenis_indeksasi_id' => $getJenisIndex,
        ]);

        $anggotaData = array_map(function ($anggota) use ($Pengabdian) {
            $anggotaPengabdian = AnggotaPengabdian::create([
                'nidn' => $anggota['nidn'],
                'email' => $anggota['email'],
                'phone_number' => $anggota['phone_number'],
                'prodi' => $anggota['prodi'],
                'name' => $anggota['name'],
                'name_with_title' => $anggota['name_with_title'],
                'scholar_id' => $anggota['scholar_id'],
                'scopus_id' => $anggota['scopus_id'],
                'job_functional' => $anggota['job_functional'],
                'affiliate_campus' => $anggota['affiliate_campus'],
                'is_leader' => $anggota['is_leader'] ?? false,
            ]);

            return [
                'pengabdian_id' => $Pengabdian->id,
                'anggota_pengabdian_id' => $anggotaPengabdian->id,
            ];
        }, $request->anggota);

        DetailPengabdian::insert($anggotaData);

        return self::getPengabdianById($Pengabdian->hash);
    }

    public static function updatePengabdian($id, PengabdianDto $request)
    {
        // TODO: Implement updatePengabdian() method.
    }
}
