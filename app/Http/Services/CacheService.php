<?php

namespace App\Http\Services;

use App\Models\Adm\CacheModel;
use Illuminate\Support\Facades\Cache;

class CacheService
{

    public static function cleanCachesInArray(?array $cacheNames): void
    {
        if (!$cacheNames) return;

        foreach ($cacheNames as $key => $cache) {
            Cache::forget($cache);
        }
    }

    public static function remember(string $cacheName, \Closure $callback, ?int $expiration = 604800)
    {
        CacheService::cacheStatus() ? '' : Cache::forget($cacheName);

        return Cache::remember($cacheName, $expiration, $callback);
    }

    public static function cacheStatus()
    {
        return CacheModel::first()->status;
    }

}