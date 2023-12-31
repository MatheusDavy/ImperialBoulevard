<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\ContactsModel;

class ContactsController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new ContactsModel();
        $this->title = 'Contato';
        $this->titlePlural = 'Contatos';
        $this->searchField = ['name', 'email', 'phone'];
        $this->justView = true;
        $this->export = true;

        $this->listFields = array(
            $this->makeListFields(null, 'Nome', 'name', 'small', null, true, true),
            $this->makeListFields(null, 'E-mail', 'email', 'big', null, false, true),
            $this->makeListFields(null, 'Data', 'regular_date', 'small', null, false, true, 'date')
        );

        $this->modalFields = array(
            $this->makeFields(null, 'Nome', 'name'),
            $this->makeFields(null, 'E-mail', 'email'),
            $this->makeFields(null, 'Telefone', 'phone'),
            $this->makeFields(null, 'Mensagem', 'message'),
            $this->makeFields(null, 'Data', 'datef'),
        );

        $this->exportFields = $this->modalFields;
    }
}
