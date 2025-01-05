<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class JenisIndeksasi extends Model
{
    use HashableId;

    protected $table = 'jenis_indeksasi';
    protected $guarded = [];

    protected $casts = [
        'kriteria' => 'array'
    ];
}
