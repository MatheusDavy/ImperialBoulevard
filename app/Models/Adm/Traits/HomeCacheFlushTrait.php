<?php

namespace App\Models\Adm\Traits;

use Illuminate\Support\Facades\Cache;

trait HomeCacheFlushTrait
{
    private function flushHomeCache()
    {
        $langs = [1, 2, 3];
        Cache::forget('homePage');
        foreach ($langs as $key => $lang) {
            Cache::forget('homePage' . $lang);
        }
    }
}
