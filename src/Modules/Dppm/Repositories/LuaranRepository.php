<?php

namespace Modules\Dppm\Repositories;

use App\Helper\Terbilang;
use App\Models\Luaran;
use App\Models\LuaranKriteria;
use Modules\Dppm\DataTransferObjects\LuaranDto;

class LuaranRepository
{
    public static function getAllLuaran()
    {
        return Luaran::query();
    }

    public static function getLuaranById(string $id)
    {
        return Luaran::with('kriteria')->byHash($id)->first();
    }

    public static function insertLuaran(LuaranDto $data)
    {
        $Luaran = Luaran::create([
            'name' => $data->name,
            'category' => $data->category,
        ]);

        foreach ($data->kriteria as $kriteria) {
            LuaranKriteria::create([
                'name' => $kriteria["name"],
                'nominal' => $kriteria["nominal"],
                'keterangan' => $kriteria["keterangan"],
                'terbilang' => self::parseTerbilang($kriteria["nominal"]),
                'luaran_id' => $Luaran->id,
            ]);
        }

        return $Luaran;
    }

    public static function updateLuaran(string $id, LuaranDto $data)
    {
        $Luaran = Luaran::byHash($id);

        $Luaran->update([
            'name' => $data->name,
        ]);

        foreach ($data->kriteria as $kriteria) {
            LuaranKriteria::where('luaran_id', $Luaran->id)->delete();

            LuaranKriteria::create([
                'name' => $kriteria["name"],
                'nominal' => $kriteria["nominal"],
                'keterangan' => $kriteria["keterangan"],
                'terbilang' => self::parseTerbilang($kriteria["nominal"]),
                'luaran_id' => $Luaran->id,
            ]);
        }

        return $Luaran;
    }

    public static function deleteLuaran(string $id)
    {
        $Luaran = Luaran::byHash($id);

        LuaranKriteria::where('luaran_id', $Luaran->id)->delete();
        $Luaran->delete();

        return $Luaran;
    }

    private static function parseTerbilang(int $nominal)
    {
        $terbilang = new Terbilang();
        $terbilang->parse($nominal);

        return $terbilang->getResult();
    }
}
