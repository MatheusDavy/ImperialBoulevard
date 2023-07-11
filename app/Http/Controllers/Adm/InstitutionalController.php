<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Adm\Traits\FieldsTraits;
use Illuminate\Http\Request;
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
            $this->textField('input', 'Fone', 'phone'),
            $this->textField('input', 'WhatsApp', 'wpp'),
            // $this->textField('input', 'WhatsApp Texto', 'wpp_text'),
            $this->textField('input', 'E-mail', 'email'),
            $this->textField('input', 'Facebook', 'facebook'),
            $this->textField('input', 'Instagram', 'instagram'),
            $this->textField('input', 'Youtube', 'youtube'),
            $this->textField('input', 'Endereço', 'address'),
            $this->textField('input', 'Google Maps Link', 'google_maps_link'),
        );
    }

    public function index(Request $request)
    {
        $route = Route::currentRouteName();
        return redirect()->route(str_replace('index', 'update', $route), '1');
    }
}
