<?php

namespace App\Http\Controllers\Adm\HomeModule;

use App\Http\Controllers\Adm\AdmController;
use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\HomeModule\FifthSectionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class FifthSectionController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new FifthSectionModel();
        $this->title = 'Quinta Seção';
        $this->titlePlural = 'Quinta Seção';

        $this->fields['Geral'] = array(
            $this->textField('input', 'Título', 'title'),
            $this->ckEditorSimpleField('Subtítulo', 'subtitle'),
        );

        $this->fields['Galeria'] = array(
            $this->galleryField('Galeria', 'gallery', 'QuintaSecao'),
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
