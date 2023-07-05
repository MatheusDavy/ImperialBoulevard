<?php

namespace App\Models\Adm;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PagesGalleryModel extends AdmModel
{
    use HasFactory;

    protected $table = 'adm_pages_gallery';

    public $timestamps = false;
}
