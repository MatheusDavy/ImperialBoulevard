<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use Illuminate\Http\Request;
use App\Models\Adm\UsersGroupsModel;
use App\Models\Adm\UsersModel;

class UsersController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new UsersModel();
        $this->title = 'Usuário';
        $this->titlePlural = 'Usuários';
        $this->searchField = 'name';
        $this->allowStatus = true;

        $this->listFields = array(
            $this->makeListFields(null, 'Nome', 'name', 'big', null, true, true)
        );

        $this->fields['Geral'] = array(
            $this->makeFields('image', 'Imagem', 'image', true, 'usuarios', true),
            $this->makeFields('checkbox', 'Status', 'status', true, null, true),
            // $this->makeFields('input', 'Login', 'login', true, null, true),
            $this->makeFields('input', 'E-mail', 'email', true, null, true),
            $this->makeFields('select', 'Grupo', 'id_group', true, null, true, 'groups'),
            $this->makeFields('input', 'Nome', 'name', true, null, true),
            array(
                'type' => 'input',
                'title' => 'Senha',
                'name' => 'password',
                'password' => true,
                'half' => false,
                'customRules' => 'required|min:8|regex:/.*((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9])(?=\S*?[@!$#])).{8,}\.*/',
                'tooltip' => 'A senha precisa ter ao menos 3 caracteres de pelo menos 3 das seguintes categorias: 
                letra maiúscula | minúscula, número, caracter especial (@$!%*#?)'
            ),
        );

        $usersGroupsModel = new UsersGroupsModel();

        $groups = $usersGroupsModel->get([
            'sort_order' => ['title', 'asc']
        ]);

        $this->data['groups'] = $groups;
    }

    public function editar(Request $request, $id)
    {
        if (!$request->input('password') || !$request->ajax()) {
            $this->fields['Geral'][5]['required'] = false;
        }
        return parent::editar($request, $id);
    }
}
