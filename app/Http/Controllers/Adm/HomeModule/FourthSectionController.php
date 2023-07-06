<?php

namespace App\Http\Controllers\Adm\HomeModule;

use App\Http\Controllers\Adm\AdmController;
use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\HomeModule\FourthSectionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class FourthSectionController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new FourthSectionModel();
        $this->title = 'Quarta Seção';
        $this->titlePlural = 'Quarta Seção';

        $this->fields['Geral'] = array(
            $this->textField('input', 'Título', 'title'),
            $this->ckEditorSimpleField('Subtítulo', 'subtitle'),
            $this->ckEditorSimpleField('Descrição', 'description'),
            $this->imageField('Imagem Esquerda', 'image_left', 'QuartaSecao', true, true),
            $this->imageField('Imagem Esquerda Mobile', 'image_left_mobile', 'QuartaSecao', true, true),
            $this->imageField('Imagem Direita', 'image_right', 'QuartaSecao', true, true),
            $this->imageField('Imagem Direita Mobile', 'image_right_mobile', 'QuartaSecao', true, true),
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
