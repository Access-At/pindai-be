<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Znck\Eloquent\Traits\BelongsToThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dosen extends Model
{
    use BelongsToThrough, HasFactory, HashableId, SoftDeletes;

    protected $table = 'dosen';

    protected $dates = ['deleted_at'];

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
        'is_approved',
        'is_active',
    ];

    public function scopeActive($query, $type = 1)
    {
        return $query->where('is_active', $type);
    }

    public function scopeApproved($query, $type = 1)
    {
        return $query->where('is_approved', $type);
    }

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
                Faculty::class => 'faculties_id',
                Prodi::class => 'prodi_id',
            ]
        );
    }
}
