<?php

namespace App\Models\Adm\HomeModule;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ThirdSectionModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_third_section';

    public $folder = 'userfiles/TerceiraSecao/';
    public $timestamps = true;
}
