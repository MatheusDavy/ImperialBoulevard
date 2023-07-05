<?php

namespace App\Http\Controllers\Adm\BlogModule;

use App\Http\Controllers\Adm\AdmController;
use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\BlogModule\AuthorsModel;

class AuthorsController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new AuthorsModel();
        $this->title = 'Author';
        $this->titlePlural = 'Authors';
        $this->searchField = 'name';
        $this->allowOrder = true;
        $this->allowStatus = true;

        $this->listFields = array(
            // $this->makeListFields('image', 'Imagem', 'image', 'small', 'posts_authors'),
            $this->makeListFields(null, 'Nome', 'name', 'small', null, true, true),
        );

        $this->fields['Geral'] = array(
            $this->makeFields('checkbox', 'Ativo?', 'status', false, null),
            // $this->makeFields('image', 'Imagem Autor', 'image', true, 'posts_authors', true),
            // $this->makeFields('image', 'Imagem Autor Mobile', 'image_mobile', true, 'posts_authors', true),
            $this->makeFields('input', 'Nome', 'name', true),
            // $this->makeFields('text', 'Bio', 'bio')
        );
    }
}
