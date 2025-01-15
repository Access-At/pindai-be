<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class DetailPenelitian extends Model
{
    use HashableId, SoftDeletes;

    protected $table = 'detail_penelitian';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'penelitian_id',
        'anggota_penelitian_id',
    ];

    public function penelitian()
    {
        return $this->belongsTo(Penelitian::class, 'penelitian_id');
    }

    public function anggotaPenelitian()
    {
        return $this->belongsTo(AnggotaPenelitian::class, 'anggota_penelitian_id');
    }

    // public function dosen()
    // {
    //     return $this->belongsTo(Dosen::class, 'anggota_penelitian_id');
    //     // return $this->hasManyThrough(
    //     //     AnggotaPenelitian::class,
    //     //     DetailPenelitian::class,
    //     //     'anggota_penelitian_id',
    //     //     'id',
    //     //     'id',
    //     //     'penelitian_id',
    //     // );
    // }
}
