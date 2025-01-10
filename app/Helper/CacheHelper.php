<?php

namespace App\Helper;

use Illuminate\Support\Facades\Cache;

class CacheHelper
{
    public static function clearCache($key)
    {
        Cache::forget($key);
    }

    public static function clearAllCache()
    {
        Cache::flush();
    }

    public static function rememberCache($key, $value)
    {
        return Cache::remember($key, 18000, $value); // 5 jam = 18000 detik
    }
}
