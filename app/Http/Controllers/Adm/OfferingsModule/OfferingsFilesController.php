<?php

namespace App\Http\Controllers\Adm\OfferingsModule;

use App\Http\Controllers\Adm\AdmController;
use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\OfferingsModule\OfferingsFilesModel;

class OfferingsFilesController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new OfferingsFilesModel();
        $this->title = 'Ofertas Públicas Arquivo';
        $this->titlePlural = 'Ofertas Públicas Arquivos';
        $this->allowOrder = true;
        $this->allowStatus = true;
        $this->searchField = 'title';

        $this->listFields = array(
            $this->makeListFields(null, 'Título', 'title', 'big')
        );

        $this->fields['Geral'] = array(
            $this->checkField('Ativo?', 'status'),
            $this->dateField('Data', 'created', false, true),
            $this->textField('input', 'Título', 'title'),
            $this->textField('text', 'Descrição', 'description'),
            $this->fileField('Arquivo', 'file', 'OfertasPublicas')
        );
    }
}
