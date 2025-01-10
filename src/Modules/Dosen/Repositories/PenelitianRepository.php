<?php

namespace Modules\Dosen\Repositories;

use App\Models\AnggotaPenelitian;
use App\Models\DetailPenelitian;
use App\Models\JenisIndeksasi;
use App\Models\JenisPenelitian;
use App\Models\Penelitian;
use Modules\Dosen\DataTransferObjects\PenelitianDto;

class PenelitianRepository
{
    public static function getAllPenelitian($perPage, $page, $search)
    {
        return Penelitian::paginate($perPage, ['*'], 'page', $page);
    }

    public static function getPenelitianById($id)
    {
        return Penelitian::byHash($id);
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
            'jenis_penelitian_id' => $getJenisPenelitian,
            'jenis_indeksasi_id' => $getJenisIndex,
        ]);

        foreach ($request->anggota as $key => $anggota) {

            $anggota = AnggotaPenelitian::create([
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

            DetailPenelitian::create([
                'penelitian_id' => $penelitian->id,
                'anggota_penelitian_id' => $anggota->id,
            ]);
        }

        return $penelitian;
    }

    public static function updatePenelitian($id, PenelitianDto $request)
    {
        // TODO: Implement updatePenelitian() method.
    }
}
