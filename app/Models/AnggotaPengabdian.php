<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaPengabdian extends Model
{
    protected $table = 'anggota_pengabdian';

    protected $fillable = [
        'email',
        'nidn',
        'phone_number',
        'prodi',
        'name',
        'name_with_title',
        'scholar_id',
        'scopus_id',
        'job_functional',
        'affiliate_campus',
        'is_leader',
    ];
}
