<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Kaprodi extends Model
{
    use HasFactory, HashableId;

    protected $table = 'kaprodi';

    protected $fillable = [
        'faculties_id',
        'user_id',
        'is_active',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculties_id');
    }
}
