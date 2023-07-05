<?php

namespace App\Models\Adm;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PagesFieldsModel extends AdmModel
{
    use HasFactory;

    protected $table = 'adm_pages_fields';

    public $timestamps = false;
}
