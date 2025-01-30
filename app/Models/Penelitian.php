<?php

namespace App\Models;

use App\Enums\Semester;
use App\Enums\StatusPenelitian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Penelitian extends Model
{
    use HashableId, SoftDeletes;

    protected $table = 'penelitian';

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
        'luaran_kriteria_id',
        'deadline_dppm',
        'keterangan',
        'status_kaprodi_date',
        'status_dppm_date',
        'status_keuangan_date',
    ];

    protected $dates = [
        'deleted_at',
        'deadline_dppm',
        'status_kaprodi_date',
        'status_dppm_date',
        'status_keuangan_date',
    ];

    public function getAnggotaAttribute()
    {
        return $this->detail()->with(['anggotaPenelitian'])->get();
    }

    public function getCategoryAttribute()
    {
        return "Penelitian";
    }

    public function getKetuaAttribute()
    {
        $detail = $this->detail()->with(['anggotaPenelitian' => function ($q) {
            $q->where('is_leader', true);
        }])->first();

        return $detail ? $detail->anggotaPenelitian : null;
    }

    public function scopeMyPenelitian($query)
    {
        return $query->whereHas('detail', function ($query) {
            $query->whereHas('anggotaPenelitian', function ($q) {
                $q->where('email', auth()->user()->email);
            });
        });
    }

    public function scopeProdiPenelitian($query, $prodi)
    {
        return $query->whereHas('detail', function ($query) use ($prodi) {
            $query->whereHas('anggotaPenelitian', function ($q) use ($prodi) {
                $q->whereIn('prodi', $prodi)->where('is_leader', true);
            });
        });
    }

    public function detail()
    {
        return $this->hasMany(DetailPenelitian::class);
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

            if (! $latestKode) {
                $nextNumber = '001';
            } else {
                $lastNumber = (int) (mb_substr($latestKode->kode, -3));
                $nextNumber = mb_str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
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
            'status_keuangan' => StatusPenelitian::class,
        ];
    }
}
