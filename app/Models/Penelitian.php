<?php

namespace App\Models;

use App\Enums\Semester;
use App\Enums\StatusPenelitian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Penelitian extends Model
{
    use SoftDeletes, HashableId;

    protected $table = 'penelitian';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'kode',
        'judul',
        'tahun_akademik',
        'semester',
        'deskripsi',
        'status_kaprodi',
        'status_dppm',
        'jenis_penelitian_id',
        'jenis_indeksasi_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $latestKode = static::withTrashed()->latest()->first();
            $tahun = date('Y');

            if (!$latestKode) {
                $nextNumber = '001';
            } else {
                $lastNumber = intval(substr($latestKode->kode, -3));
                $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            }

            $model->kode = 'PEN-' . $tahun . '-' . $nextNumber;
        });
    }

    protected function casts(): array
    {
        return [
            'semester' => Semester::class,
            'status_kaprodi' => StatusPenelitian::class,
            'status_dppm' => StatusPenelitian::class,
        ];
    }

    public function detail()
    {
        return $this->hasMany(DetailPenelitian::class);
    }


    public function getAnggotaAttribute()
    {
        return $this->detail()->with(['anggotaPenelitian'])->get();
    }

    public function getKetuaAttribute()
    {
        // NOTE: change name with title or not
        $detail = $this->detail()->with(['anggotaPenelitian' => function ($q) {
            $q->where('is_leader', true);
        }])->first();

        return $detail ? $detail->anggotaPenelitian->name_with_title ?? $detail->anggotaPenelitian->name  : null;
    }
}
