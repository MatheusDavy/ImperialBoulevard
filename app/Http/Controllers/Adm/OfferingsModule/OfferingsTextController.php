<?php

namespace App\Http\Controllers\Adm\OfferingsModule;

use App\Http\Controllers\Adm\AdmController;
use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\OfferingsModule\OfferingsTextModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class OfferingsTextController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new OfferingsTextModel();
        $this->title = 'Ofertas Públicas Descrição';
        $this->titlePlural = 'Ofertas Públicas Descrição';

        $this->fields['Geral'] = array(
            $this->textField('text', 'Descrição', 'description'),
        );
    }

    public function index(Request $request)
    {
        $route = Route::currentRouteName();
        if (!$this->model->first()) {
            DB::table($this->model->getTable())->insert(['id' => 1]);
        }
        return redirect()->route(str_replace('index', 'update', $route), '1');
    }
}
