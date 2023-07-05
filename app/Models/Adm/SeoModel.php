<?php

namespace App\Models\Adm;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeoModel extends AdmModel
{
    use HasFactory;

    protected $table = 'adm_seo';

    public $timestamps = false;
}
