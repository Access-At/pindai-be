<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPengabdianModel extends Model
{
    protected $table = 'jenis_pengabdian';
    protected $guarded = [];

    protected $casts = [
       'kriteria' => 'array'
    ];
}
