<?php

namespace App\Http\Controllers\Adm\HomeModule;

use App\Http\Controllers\Adm\AdmController;
use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\HomeModule\SixthSectionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SixthSectionController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new SixthSectionModel();
        $this->title = 'Sexta Seção';
        $this->titlePlural = 'Sexta Seção';

        $this->fields['Geral'] = array(
            $this->textField('input', 'Título Acima', 'above_title'),
            $this->ckEditorSimpleField('Título', 'title'),
            $this->ckEditorSimpleField('Descrição', 'description'),
            $this->imageField('Imagem Esquerda', 'image_left', 'SextaSecao', true, true),
            $this->imageField('Imagem Esquerda Mobile', 'image_left_mobile', 'SextaSecao', true, true),
            $this->imageField('Imagem Direita', 'image_right', 'SextaSecao', true, true),
            $this->imageField('Imagem Direita Mobile', 'image_right_mobile', 'SextaSecao', true, true),
            $this->textField('input', 'Botão Texto', 'button_text'),
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
