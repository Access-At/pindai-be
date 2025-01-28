<?php

namespace App\Models;

use App\Enums\Semester;
use App\Enums\StatusPenelitian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Pengabdian extends Model
{
    use HashableId, SoftDeletes;

    protected $table = 'pengabdian';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'kode',
        'judul',
        'tahun_akademik',
        'semester',
        'deskripsi',
        'bidang',
        'status_kaprodi',
        'status_dppm',
        'status_keuangan',
        'keterangan',
        'luaran_kriteria_id',

        // 'jenis_pengabdian_id',
        // 'jenis_indeksasi_id',
        // 'luaran_id'
    ];

    public function getAnggotaAttribute()
    {
        return $this->detail()->with(['anggotaPengabdian'])->get();
    }

    public function getKetuaAttribute()
    {
        $detail = $this->detail()->with(['anggotaPengabdian' => function ($q) {
            $q->where('is_leader', true);
        }])->first();

        return $detail ? $detail->anggotaPengabdian : null;
    }

    public function scopeMyPengabdian($query)
    {
        return $query->whereHas('detail', function ($query) {
            $query->whereHas('anggotaPengabdian', function ($q) {
                $q->where('email', auth()->user()->email);
            });
        });
    }

    public function scopeProdiPengabdian($query, $prodi)
    {
        return $query->whereHas('detail', function ($query) use ($prodi) {
            $query->whereHas('anggotaPengabdian', function ($q) use ($prodi) {
                $q->whereIn('prodi', $prodi)->where('is_leader', true);
            });
        });
    }

    public function detail()
    {
        return $this->hasMany(DetailPengabdian::class);
    }

    public function kriteria()
    {
        return $this->belongsTo(LuaranKriteria::class, 'luaran_kriteria_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $latestKode = static::withTrashed()->latest()->first();
            $tahun = date('Y');

            if ( ! $latestKode) {
                $nextNumber = '001';
            } else {
                $lastNumber = (int) (mb_substr($latestKode->kode, -3));
                $nextNumber = mb_str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            }

            $model->kode = 'PENG-' . $tahun . '-' . $nextNumber;
        });
    }

    protected function casts(): array
    {
        return [
            'semester' => Semester::class,
            'status_kaprodi' => StatusPenelitian::class,
            'status_dppm' => StatusPenelitian::class,
            'status_keuangan' => StatusPenelitian::class,
        ];
    }
}
