<?php

namespace App\Http\Controllers\Adm\HomeModule;

use App\Http\Controllers\Adm\AdmController;
use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\HomeModule\FirstSectionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class FirstSectionController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new FirstSectionModel();
        $this->title = 'Primeira Seção';
        $this->titlePlural = 'Primeira Seção';

        $this->fields['Geral'] = array(
            $this->imageField('Imagem', 'image', 'PrimeiraSecao', true, true),
            $this->imageField('Imagem Mobile', 'image_mobile', 'PrimeiraSecao', true, true),
            $this->textField('input', 'Título Acima', 'above_title'),
            $this->textField('input', 'Título', 'title'),
            $this->ckEditorSimpleField('Subtítulo', 'subtitle'),
            $this->textField('input', 'Local', 'location'),
            $this->textField('input', 'Botão Texto', 'button_title'),
            $this->textField('input', 'Botão Link', 'button_link'),
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
