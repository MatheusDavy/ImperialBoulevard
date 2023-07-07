<?php

namespace App\Models\Adm\HomeModule;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FifthSectionModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_fifth_section';
    protected $galleryTable = 'site_fifth_section_gallery';
    protected $foreignKey = 'id_section';

    public $folder = 'userfiles/QuintaSecao/';
    public $timestamps = true;
}
