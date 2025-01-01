<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPenelitianModel extends Model
{
    protected $table = 'jenis_penelitian';
    protected $guarded = [];

    protected $casts = [
       'kriteria' => 'array'
    ];
}
