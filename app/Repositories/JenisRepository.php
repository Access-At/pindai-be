<?php

namespace App\Repositories;

use App\Models\JenisIndeksasiModel;
use App\Models\JenisPenelitianModel;

class JenisRepository{
    public static function getJenisPenelitian(){
        try {
            $penelitian = JenisPenelitianModel::get();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public static function getJenisIndeksasi(){
        try {
            $penelitian = JenisIndeksasiModel::get();
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}