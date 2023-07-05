<?php

namespace App\Models\Adm;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsGalleryModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_news_gallery';

    public $timestamps = false;
}
