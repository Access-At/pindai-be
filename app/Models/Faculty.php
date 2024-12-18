<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;
// use \Znck\Eloquent\Traits\BelongsToThrough;

class Faculty extends Model
{
    use HasFactory, HashableId;

    protected $fillable = [
        'name',
    ];

    public function dosen()
    {
        return $this->hasMany(Dosen::class, 'prodi_id', 'id');
    }
}
