<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Prodi extends Model
{
    use HasFactory, HashableId;

    protected $table = 'prodi';

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculties_id');
    }
}