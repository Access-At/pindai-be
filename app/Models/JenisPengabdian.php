<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class JenisPengabdian extends Model
{
    use HashableId;

    protected $table = 'jenis_pengabdian';
    protected $guarded = [];

    protected $casts = [
        'kriteria' => 'array'
    ];
}
