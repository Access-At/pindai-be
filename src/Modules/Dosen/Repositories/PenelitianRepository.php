<?php

namespace Modules\Dosen\Repositories;

use App\Models\Penelitian;
use App\Models\LuaranKriteria;
use App\Models\DetailPenelitian;
use App\Models\AnggotaPenelitian;
use Modules\Dosen\DataTransferObjects\PenelitianDto;

class PenelitianRepository
{
    public static function getAllPenelitian()
    {
        return Penelitian::myPenelitian();
    }

    public static function getPenelitianById($id)
    {
        return Penelitian::with(['detail.anggotaPenelitian', 'kriteria', 'kriteria.luaran'])
            ->byHash($id)->first();
    }

    public static function insertPenelitian(PenelitianDto $request)
    {
        $getLuaranPenelitian = LuaranKriteria::byHash($request->luaran_kriteria)->id;

        $penelitian = Penelitian::create([
            'tahun_akademik' => $request->tahun_akademik,
            'semester' => $request->semester,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'bidang' => $request->bidang,
            'luaran_kriteria_id' => $getLuaranPenelitian,
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

    public static function deletePenelitian($id)
    {
        $penelitian = Penelitian::byHash($id);

        $penelitian->detail()->delete();
        $penelitian->delete();

        return $penelitian;
    }
}
