<?php

namespace App\Models\Adm;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompaniesModel extends AdmModel
{
    use HasFactory;

    protected $table = 'adm_companies';

    public $timestamps = false;
}
