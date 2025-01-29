<?php

namespace Modules\Dppm\Repositories;

use App\Models\Luaran;
use App\Helper\Terbilang;
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
        $luaran = Luaran::create([
            'name' => $data->name,
            'category' => $data->category,
        ]);

        foreach ($data->kriteria as $kriteria) {
            LuaranKriteria::create([
                'name' => $kriteria['name'],
                'nominal' => $kriteria['nominal'],
                'keterangan' => $kriteria['keterangan'],
                'terbilang' => self::parseTerbilang($kriteria['nominal']),
                'luaran_id' => $luaran->id,
            ]);
        }

        return $luaran;
    }

    public static function updateLuaran(string $id, LuaranDto $data)
    {
        $luaran = Luaran::byHash($id);

        $luaran->update([
            'name' => $data->name,
        ]);

        LuaranKriteria::where('luaran_id', $luaran->id)->delete();

        foreach ($data->kriteria as $kriteria) {
            LuaranKriteria::create([
                'name' => $kriteria['name'],
                'nominal' => $kriteria['nominal'],
                'keterangan' => $kriteria['keterangan'],
                'terbilang' => self::parseTerbilang($kriteria['nominal']),
                'luaran_id' => $luaran->id,
            ]);
        }

        return $luaran;
    }

    public static function deleteLuaran(string $id)
    {
        $luaran = Luaran::byHash($id);

        LuaranKriteria::where('luaran_id', $luaran->id)->delete();
        $luaran->delete();

        return $luaran;
    }

    private static function parseTerbilang(int $nominal)
    {
        $terbilang = new Terbilang;
        $terbilang->parse($nominal);

        return $terbilang->getResult();
    }
}
