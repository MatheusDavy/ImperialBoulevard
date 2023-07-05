<?php

namespace App\Models\Adm;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class CacheModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_cache';
    public $timestamps = false;

    public static function flushCache()
    {
        Cache::flush();
    }
}