<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NomorDokumen extends Model
{
    protected $table = 'nomor_dokumen';

    protected $fillable = [
        'nomor',
        'kode_dokumen',
        'jenis_dokumen',
        'tahun_dokumen',
    ];

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($model) {
            $currentYear = date('Y');
            if ($model->tahun_dokumen != $currentYear) {
                $model->tahun_dokumen = $currentYear;
                $model->nomor = '001';
            } else {
                $lastNumber = static::where('jenis_dokumen', $model->jenis_dokumen)
                    ->where('tahun_dokumen', $currentYear)
                    ->max('nomor');

                $model->nomor = $lastNumber ? str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT) : '001';
            }
            $model->save();
        });
    }
}
