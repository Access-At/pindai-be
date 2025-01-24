<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class DetailPengabdian extends Model
{
    use HashableId, SoftDeletes;

    protected $table = 'detail_pengabdian';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'pengabdian_id',
        'anggota_pengabdian_id',
    ];

    public function pengabdian()
    {
        return $this->belongsTo(Penelitian::class, 'pengabdian_id');
    }

    public function anggotaPengabdian()
    {
        return $this->belongsTo(AnggotaPengabdian::class, 'anggota_pengabdian_id');
    }
}
