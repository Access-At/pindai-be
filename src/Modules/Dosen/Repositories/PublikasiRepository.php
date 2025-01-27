<?php

namespace Modules\Dosen\Repositories;

use App\Models\Luaran;
use App\Models\Publikasi;
use App\Models\LuaranKriteria;
use Carbon\Carbon;
use Modules\Dosen\DataTransferObjects\PublikasiDto;

class PublikasiRepository
{
    public static function getAllPublikasi()
    {
        return Publikasi::myPublikasi()->with(['publikasi', 'kriteria']);
    }

    public static function getPublikasiById($id)
    {
        return Publikasi::with(['publikasi', 'kriteria'])
            ->byHash($id)->first();
    }

    public static function insertPublikasi(PublikasiDto $request)
    {
        $user = auth('api')->user();

        $getKriteria = LuaranKriteria::byHash($request->luaran_kriteria)->id;
        $getJenis = Luaran::byHash($request->jenis_publikasi)->id;

        $publikasi = Publikasi::create([
            'judul' => $request->judul,
            'authors' => $request->author,
            'jenis_publikasi' => $getJenis,
            'tanggal_publikasi' => Carbon::parse($request->tanggal_publikasi)->format('Y-m-d'),
            'tahun' => $request->tahun,
            'jurnal' => $request->jurnal,
            'link_publikasi' => $request->link_publikasi,
            'luaran_kriteria_id' => $getKriteria,
            'user_id' => $user->id,
        ]);

        return self::getPublikasiById($publikasi->hash);
    }

    public static function updatePublikasi($id, PublikasiDto $request)
    {
        $user = auth('api')->user();
        $getKriteria = LuaranKriteria::byHash($request->luaran_kriteria)->id;
        $getJenis = Luaran::byHash($request->jenis_publikasi)->id;

        $publikasi = Publikasi::byHash($id);

        $publikasi->update([
            'judul' => $request->judul,
            'authors' => $request->author,
            'jenis_publikasi' => $getJenis,
            'tanggal_publikasi' => Carbon::parse($request->tanggal_publikasi)->format('Y-m-d'),
            'tahun' => $request->tahun,
            'jurnal' => $request->jurnal,
            'link_publikasi' => $request->link_publikasi,
            'luaran_kriteria_id' => $getKriteria,
            'user_id' => $user->id,
        ]);

        return self::getPublikasiById($publikasi->hash);
    }

    public static function deletePublikasi($id)
    {
        $publikasi = Publikasi::byHash($id);
        $publikasi->delete();

        return $publikasi;
    }
}
