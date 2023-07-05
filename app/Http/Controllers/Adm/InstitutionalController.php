<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Adm\Traits\FieldsTraits;
use Illuminate\Http\Request;
use App\Models\Adm\CompaniesModel;
use App\Models\Adm\InstitutionalModel;
use Illuminate\Support\Facades\Route as Route;

class InstitutionalController extends AdmController
{
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new InstitutionalModel();
        $this->title = 'Institucional';
        $this->titlePlural = 'Institucional';
        $this->searchField = 'title';

        $this->fields['Geral'] = array(
            $this->makeFields('checkbox', 'Ativo?', 'status'),
            $this->makeFields('image', 'Imagem', 'image', false, 'institucional', true),
            $this->makeFields('input', 'Título', 'title'),
            $this->makeFields('text', 'Texto', 'text'),
        );
    }

    public function index(Request $request)
    {
        $route = Route::currentRouteName();
        return redirect()->route(str_replace('index', 'update', $route), '1');
    }
}
