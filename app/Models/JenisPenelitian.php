<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class JenisPenelitian extends Model
{
    use HashableId;

    protected $table = 'jenis_penelitian';

    protected $guarded = [];

    protected $casts = [
        'kriteria' => 'array',
    ];
}
