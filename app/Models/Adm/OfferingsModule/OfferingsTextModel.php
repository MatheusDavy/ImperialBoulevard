<?php

namespace App\Models\Adm\OfferingsModule;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfferingsTextModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_public_offerings_text';

    public $timestamps = true;
}
