<?php

namespace App\Http\Controllers\Adm\HomeModule;

use App\Http\Controllers\Adm\AdmController;
use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\HomeModule\ThirdSectionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ThirdSectionController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new ThirdSectionModel();
        $this->title = 'Terceira Seção';
        $this->titlePlural = 'Terceira Seção';

        $this->fields['Geral'] = array(
            $this->textField('input', 'Título', 'title'),
            $this->ckEditorSimpleField('Descrição', 'description'),
            $this->imageField('Imagem Topo', 'image_top', 'TerceiraSecao', true, true),
            $this->imageField('Imagem Topo Mobile', 'image_top_mobile', 'TerceiraSecao', true, true),
            $this->imageField('Imagem Direita', 'image_right', 'TerceiraSecao', true, true),
            $this->imageField('Imagem Direita Mobile', 'image_right_mobile', 'TerceiraSecao', true, true),
            $this->imageField('Imagem Base', 'image_bottom', 'TerceiraSecao', true, true),
            $this->imageField('Imagem Base Mobile', 'image_bottom_mobile', 'TerceiraSecao', true, true),
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
