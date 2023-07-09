<?php

namespace App\Models\Adm\HomeModule;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FifthSectionGalleryModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_fifth_section_gallery';
    public $timestamps = false;
}
