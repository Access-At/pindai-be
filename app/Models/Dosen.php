<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;
use \Znck\Eloquent\Traits\BelongsToThrough;

class Dosen extends Model
{
    use HasFactory, BelongsToThrough, HashableId;

    protected $table = 'dosen';

    protected $fillable = [
        'user_id',
        'prodi_id',
        'nidn',
        'name_with_title',
        'phone_number',
        'scholar_id',
        'scopus_id',
        'job_functional',
        'affiliate_campus',
    ];

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
