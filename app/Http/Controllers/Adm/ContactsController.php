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
        $this->searchField = 'name';
        $this->justView = true;
        $this->export = true;

        $this->listFields = array(
            $this->makeListFields(null, 'Nome', 'name', 'big', null, true, true),
            $this->makeListFields(null, 'Data', 'regular_date', 'small', null, false, true, 'date'),
        );

        $this->modalFields = array(
            $this->makeFields(null, 'Nome', 'name', false, null, true),
            $this->makeFields(null, 'E-mail', 'email', false, null, true),
            $this->makeFields(null, 'Assunto', 'subject', false, null, true),
            $this->makeFields(null, 'Data', 'datef', false, null, true),
            $this->makeFields(null, 'Mensagem', 'message'),
        );

        $this->exportFields = $this->modalFields;
    }
}
