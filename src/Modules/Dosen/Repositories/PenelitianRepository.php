<?php

namespace Modules\Dosen\Repositories;

use App\Models\AnggotaPenelitian;
use App\Models\DetailPenelitian;
use App\Models\JenisIndeksasi;
use App\Models\JenisPenelitian;
use App\Models\Penelitian;
use App\Models\User;
use Modules\Dosen\DataTransferObjects\PenelitianDto;

class PenelitianRepository
{
    public static function getAllPenelitian()
    {
        return Penelitian::myPenelitian();
    }

    public static function getPenelitianById($id)
    {
        return Penelitian::with(['jenisPenelitian', 'jenisIndex', 'detail.anggotaPenelitian'])
            ->byHash($id)
            ->first();
    }

    public static function insertPenelitian(PenelitianDto $request)
    {
        $getJenisPenelitian = JenisPenelitian::byHash($request->jenis_penelitian)->id;
        $getJenisIndex = JenisIndeksasi::byHash($request->jenis_indeksasi)->id;


        $penelitian = Penelitian::create([
            'tahun_akademik' => $request->tahun_akademik,
            'semester' => $request->semester,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'bidang' => $request->bidang,
            'jenis_penelitian_id' => $getJenisPenelitian,
            'jenis_indeksasi_id' => $getJenisIndex,
        ]);

        $anggotaData = array_map(function ($anggota) use ($penelitian) {
            $anggotaPenelitian = AnggotaPenelitian::create([
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
                'penelitian_id' => $penelitian->id,
                'anggota_penelitian_id' => $anggotaPenelitian->id,
            ];
        }, $request->anggota);

        DetailPenelitian::insert($anggotaData);

        return self::getPenelitianById($penelitian->hash);
    }

    public static function updatePenelitian($id, PenelitianDto $request)
    {
        // TODO: Implement updatePenelitian() method.
    }
}
