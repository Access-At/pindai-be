<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kaprodi extends Model
{
    use HasFactory, HashableId, SoftDeletes;

    protected $table = 'kaprodi';

    protected $fillable = [
        'faculties_id',
        'user_id',
        'is_active',
    ];

    protected $dates = ['deleted_at'];

    public function scopeActive($query, $type = 1)
    {
        return $query->where('is_active', $type);
    }


    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculties_id');
    }
}
