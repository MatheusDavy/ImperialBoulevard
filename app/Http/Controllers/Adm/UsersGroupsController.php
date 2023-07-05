<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\CommonModel;
use App\Models\Adm\UsersGroupsModel;

class UsersGroupsController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new UsersGroupsModel();
        $this->title = 'Grupo';
        $this->titlePlural = 'Grupos';
        $this->searchField = 'title';
        $this->commonModel = new CommonModel();

        $this->listFields = array(
            $this->makeListFields(null, 'Título', 'title', 'big', null, true, true)
        );

        $this->fields['Geral'] = array(
            $this->makeFields('input', 'Título', 'title', true),
            $this->makeFields('multiple_checkbox', 'Permissões', 'permissions', false, null, false, 'all_modules'),
        );

        $modules = $this->commonModel->getModules();

        $itens = array();

        foreach ($modules as $key => $module) {
            if ($module->children) {
                foreach ($module->children as $key => $child) {
                    $child->title = $module->title . ' / ' . $child->title;
                    $itens[] = $child;
                }
            } else {
                $itens[] =  $module;
            }
        }

        $this->data['all_modules'] = $itens;
    }
}
