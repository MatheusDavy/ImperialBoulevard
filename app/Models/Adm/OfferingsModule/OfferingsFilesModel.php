<?php

namespace App\Models\Adm\OfferingsModule;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfferingsFilesModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_public_offerings';
    protected $customSelect = 'created as regular_date, date_format(created, "%d/%m/%Y") as created';

    public $folder = 'userfiles/OfertasPublicas/';
    public $timestamps = true;
}
