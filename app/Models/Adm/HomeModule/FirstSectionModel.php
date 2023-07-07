<?php

namespace App\Models\Adm\HomeModule;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FirstSectionModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_first_section';
    protected $galleryTable = 'site_first_section_gallery';
    protected $foreignKey = 'id_section';

    public $folder = 'userfiles/PrimeiraSecao/';
    public $timestamps = true;

    public function gallery()
    {
        return $this->hasMany(FirstSectionGalleryModel::class, 'id_section');
    }
}
