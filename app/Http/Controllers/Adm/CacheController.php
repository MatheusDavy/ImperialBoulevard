<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\CacheModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CacheController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new CacheModel();
        $this->title = 'Cache';
        $this->titlePlural = 'Cache';
        $this->allowActions = false;
        $this->allowStatus = true;
        $this->allowSearch = false;
        $this->noInsert = true;

        $this->listFields = array(
            $this->makeListFields(null, 'Título', 'title', 'small', null, true, true),
        );
    }

}