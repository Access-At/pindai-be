<?php

namespace App\Models;

use App\Enums\Semester;
use App\Enums\StatusPenelitian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Penelitian extends Model
{
    use SoftDeletes;

    protected $table = 'penelitian';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'kode',
        'judul',
        'tahun_akademik',
        'semester',
        'deskripsi',
        'status_kaprodi',
        'status_dppm',
        'jenis_penelitian_id',
        'jenis_indeksasi_id',
    ];

    protected function casts(): array
    {
        return [
            'semester' => Semester::class,
            'status_kaprodi' => StatusPenelitian::class,
            'status_dppm' => StatusPenelitian::class,
        ];
    }
}
