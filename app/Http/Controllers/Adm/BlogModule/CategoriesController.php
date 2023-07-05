<?php

namespace App\Http\Controllers\Adm\BlogModule;

use App\Http\Controllers\Adm\AdmController;
use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\BlogModule\CategoriesModel;

class CategoriesController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new CategoriesModel();
        $this->title = 'Category';
        $this->titlePlural = 'Categories';
        $this->allowOrder = true;
        $this->allowStatus = true;
        $this->searchField = 'title';

        $this->listFields = array(
            $this->makeListFields(null, 'Título', 'title', 'small', null, true, true),
        );

        $this->fields['Geral'] = array(
            $this->makeFields('checkbox', 'Ativo?', 'status', false, null, true),
            $this->makeFields('input', 'Título', 'title', true),
        );
    }
}
