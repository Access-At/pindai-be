<?php

namespace App\Models;

use App\Enums\LuaranCategory;
use Illuminate\Database\Eloquent\Model;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Luaran extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes, HashableId;

    protected $table = 'luaran';
    protected $fillable = ['category', 'name'];

    public function kriteria()
    {
        return $this->hasMany(LuaranKriteria::class);
    }

    protected function casts(): array
    {
        return [
            'category' => LuaranCategory::class
        ];
    }
}
