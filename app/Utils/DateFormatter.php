<?php

namespace App\Utils;

use Carbon\Carbon;

class DateFormatter
{
    public static function formatTahunAjaran(string $tahunAkademik): string
    {
        return mb_substr($tahunAkademik, 0, 4) . '/' . mb_substr($tahunAkademik, 4, 4);
    }

    public static function formatTanggal($tanggal): string
    {
        $carbonDate = Carbon::parse($tanggal);

        $hari = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];

        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $hariNama = $hari[$carbonDate->format('l')];
        $tanggalTeks = self::angkaKeTeks((int) $carbonDate->format('d'));
        $bulanNama = $bulan[(int) $carbonDate->format('m')];
        $tahunTeks = self::angkaKeTeks((int) $carbonDate->format('Y'));

        return "{$hariNama} tanggal {$tanggalTeks} bulan {$bulanNama} tahun {$tahunTeks}";
    }

    private static function angkaKeTeks($angka): string
    {
        $angkaText = [
            0 => 'Nol',
            1 => 'Satu',
            2 => 'Dua',
            3 => 'Tiga',
            4 => 'Empat',
            5 => 'Lima',
            6 => 'Enam',
            7 => 'Tujuh',
            8 => 'Delapan',
            9 => 'Sembilan',
            10 => 'Sepuluh',
            11 => 'Sebelas',
            12 => 'Dua Belas',
            13 => 'Tiga Belas',
            14 => 'Empat Belas',
            15 => 'Lima Belas',
            16 => 'Enam Belas',
            17 => 'Tujuh Belas',
            18 => 'Delapan Belas',
            19 => 'Sembilan Belas',
            20 => 'Dua Puluh',
            30 => 'Tiga Puluh',
            40 => 'Empat Puluh',
            50 => 'Lima Puluh',
            60 => 'Enam Puluh',
            70 => 'Tujuh Puluh',
            80 => 'Delapan Puluh',
            90 => 'Sembilan Puluh',
        ];

        if ($angka <= 20) {
            return $angkaText[$angka];
        }
        if ($angka < 100) {
            $puluhan = floor($angka / 10) * 10;
            $satuan = $angka % 10;

            return $angkaText[$puluhan] . ($satuan ? ' ' . $angkaText[$satuan] : '');
        }
        if ($angka < 1000) {
            $ratusan = floor($angka / 100);
            $sisa = $angka % 100;

            return $angkaText[$ratusan] . ' Ratus' . ($sisa ? ' ' . self::angkaKeTeks($sisa) : '');
        }
        if ($angka < 10000) {
            $ribuan = floor($angka / 1000);
            $sisa = $angka % 1000;

            return $angkaText[$ribuan] . ' Ribu' . ($sisa ? ' ' . self::angkaKeTeks($sisa) : '');
        }
    }
}
