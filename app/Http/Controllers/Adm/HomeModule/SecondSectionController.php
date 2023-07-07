<?php

namespace App\Http\Controllers\Adm\HomeModule;

use App\Http\Controllers\Adm\AdmController;
use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\HomeModule\SecondSectionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SecondSectionController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new SecondSectionModel();
        $this->title = 'Segunda Seção';
        $this->titlePlural = 'Segunda Seção';

        $this->fields['Geral'] = array(
            $this->textField('input', 'Título Acima', 'above_title'),
            $this->textField('input', 'Título', 'title'),
            $this->ckEditorSimpleField('Descrição', 'description'),
            $this->imageField('Imagem Topo', 'image_top', 'SegundaSecao', true, true),
            $this->imageField('Imagem Topo Mobile', 'image_top_mobile', 'SegundaSecao', true, true),
            $this->imageField('Imagem Direita', 'image_right', 'SegundaSecao', true, true),
            $this->imageField('Imagem Direita Mobile', 'image_right_mobile', 'SegundaSecao', true, true),
            $this->imageField('Imagem Base', 'image_bottom', 'SegundaSecao', true, true),
            $this->imageField('Imagem Base Mobile', 'image_bottom_mobile', 'SegundaSecao', true, true),
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
