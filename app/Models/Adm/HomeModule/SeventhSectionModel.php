<?php

namespace App\Models\Adm\HomeModule;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeventhSectionModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_seventh_section';

    public $folder = 'SetimaSecao';
    public $timestamps = true;
}
