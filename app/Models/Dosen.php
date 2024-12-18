<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Znck\Eloquent\Traits\BelongsToThrough;

class Dosen extends Model
{
    use HasFactory, BelongsToThrough;

    protected $table = 'dosen';

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function fakultas()
    {
        return $this->belongsToThrough(
            Faculty::class,
            Prodi::class,
            'faculties_id',
            '',
            [
                Faculty::class => 'id',
                Prodi::class => 'prodi_id',
            ]
        );
    }
}
