<?php

namespace App\Models\Adm\HomeModule;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SecondSectionModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_second_section';

    public $folder = 'userfiles/SegundaSecao/';
    public $timestamps = true;
}
