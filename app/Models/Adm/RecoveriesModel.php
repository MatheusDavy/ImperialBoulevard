<?php

namespace App\Models\Adm;

use App\Models\Adm\AdmModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecoveriesModel extends AdmModel
{
    use HasFactory;

    protected $table = 'adm_recoveries';

    public $timestamps = false;
}
