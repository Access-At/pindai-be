<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisIndeksasiModel extends Model
{
    protected $table = 'jenis_indeksasi';
    protected $guarded = [];

    protected $casts = [
       'kriteria' => 'array'
    ];
}
