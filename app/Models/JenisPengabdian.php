<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPengabdian extends Model
{
    protected $table = 'jenis_pengabdian';
    protected $guarded = [];

    protected $casts = [
        'kriteria' => 'array'
    ];
}
