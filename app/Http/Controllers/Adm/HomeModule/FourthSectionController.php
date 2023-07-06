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

        $this->fields['Parte 1'] = array(
            $this->ckEditorSimpleField('Descrição', 'description_1'),
            $this->imageField('Imagem', 'image_1', 'QuartaSecao', true, true),
            $this->imageField('Imagem Mobile', 'image_1_mobile', 'QuartaSecao', true, true),
        );

        $this->fields['Parte 2'] = array(
            $this->ckEditorSimpleField('Descrição', 'description_2'),
            $this->ckEditorSimpleField('Subtítulo', 'subtitle_2'),
            $this->imageField('Imagem', 'image_2', 'QuartaSecao', true, true),
            $this->imageField('Imagem Mobile', 'image_2_mobile', 'QuartaSecao', true, true),
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
