<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\ModulesModel;

class ModulesController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new ModulesModel();
        $this->title = 'Módulo';
        $this->titlePlural = 'Módulos';
        $this->allowOrder = true;
        $this->allowStatus = true;
        $this->searchField = 'title';

        $this->listFields = array(
            $this->makeListFields(null, 'Título', 'title', 'big', null, true),
            $this->makeListFields(null, 'Pai', 'parent'),
        );

        $this->fields['Geral'] = array(
            $this->makeFields('checkbox', 'Ativo?', 'status'),
            $this->makeFields('input', 'Título', 'title', true),
            $this->makeFields('select', 'Pai', 'parent', false, null, false, 'parents'),
            $this->makeFields('input', 'URL', 'url'),
            $this->makeFields('input', 'Rota', 'route'),
            $this->makeFields('input', 'Ícone', 'icon', true),
        );

        $parents = $this->model->get();

        foreach ($parents as $k => $item) {
            if ($item->id_parent) {
                unset($parents[$k]);
            }
        }

        $this->data['parents'] = $parents;
    }
}
