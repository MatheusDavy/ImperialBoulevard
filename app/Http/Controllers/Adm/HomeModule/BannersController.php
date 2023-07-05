<?php

namespace App\Http\Controllers\Adm\HomeModule;

use App\Http\Controllers\Adm\AdmController;
use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\HomeModule\BannersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class BannersController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new BannersModel();
        $this->title = 'Banner';
        $this->titlePlural = 'Banners';
        $this->allowOrder = true;
        $this->allowStatus = true;
        $this->searchField = 'title';

        $this->listFields = array(
            $this->makeListFields('image', 'Imagem', 'image', 'small', 'banners'),
            $this->makeListFields(null, 'Título', 'title', 'big', null, true, true)
        );

        $this->fields['Geral'] = array(
            $this->makeFields('checkbox', 'Ativo?', 'status', false, null, true),
            $this->makeFields('image', 'Imagem', 'image', true, 'banners', true),
            $this->makeFields('input', 'Título', 'title', true),
            $this->makeFields('text', 'Texto', 'text'),
            $this->makeFields('link', 'Link', 'link'),
        );
    }

}
