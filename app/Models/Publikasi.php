<?php

namespace App\Models;

use App\Enums\StatusPenelitian;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Veelasky\LaravelHashId\Eloquent\HashableId;

class Publikasi extends Model
{
    use HashableId, SoftDeletes;

    protected $table = "publikasi";

    protected $fillable = [
        'judul',
        'jenis_publikasi',
        'tanggal_publikasi',
        'tahun',
        'authors',
        'jurnal',
        'link_publikasi',
        'status_kaprodi',
        'status_dppm',
        'status_keuangan',
        'luaran_kriteria_id',
        'user_id'
    ];

    protected $dates = [
        'tanggal_publikasi',
    ];

    public function scopeMyPublikasi($query)
    {
        return $query->where('user_id', auth()->user()->id);
    }

    public function scopeProdiPublikasi($query, $prodi)
    {
        return $query->whereHas('user', function ($query) use ($prodi) {
            $query->whereHas('dosen', function ($q) use ($prodi) {
                $q->where('prodi_id', $prodi);
            });
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function publikasi()
    {
        return $this->belongsTo(Luaran::class, 'jenis_publikasi');
    }

    public function kriteria()
    {
        return $this->belongsTo(LuaranKriteria::class, 'luaran_kriteria_id');
    }

    protected function casts(): array
    {
        return [
            'status_kaprodi' => StatusPenelitian::class,
            'status_dppm' => StatusPenelitian::class,
            'status_keuangan' => StatusPenelitian::class,
        ];
    }
}
