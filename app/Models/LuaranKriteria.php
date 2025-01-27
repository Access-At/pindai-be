<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class LuaranKriteria extends Model
{
    use HashableId;

    protected $table = 'luaran_kriteria';
    protected $fillable = ['name', 'nominal', 'terbilang', 'keterangan', 'luaran_id'];

    public function luaran()
    {
        return $this->belongsTo(Luaran::class);
    }
}
