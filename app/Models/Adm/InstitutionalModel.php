<?php

namespace App\Models\Adm;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InstitutionalModel extends AdmModel
{
    use HasFactory;

    protected $table = 'site_institutional';

    public $timestamps = false;
}
