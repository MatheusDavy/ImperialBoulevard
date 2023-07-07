<?php

namespace App\Models\Adm\HomeModule;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FourthSectionModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_fourth_section';

    public $folder = 'userfiles/QuartaSecao/';
    public $timestamps = true;
}
