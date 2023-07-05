<?php

namespace App\Http\Controllers\Adm;

use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\SeoModel;

class SeoController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new SeoModel();
        $this->title = 'SEO';
        $this->titlePlural = 'SEO';
        $this->allowOrder = true;
        $this->allowStatus = true;
        $this->searchField = 't.title';

        $this->listFields = array(
            $this->makeListFields(null, 'Título', 'title', 'big', null, true, true),
            $this->makeListFields(null, 'Slug', 'slug', 'big', null, false, true),
        );

        $this->fields['Geral'] = array(
            $this->makeFields('checkbox', 'Ativo?', 'status'),
            $this->makeFields(
                'input',
                'Título<br><small>(p/ controle)</small>',
                'title',
                true,
                null,
                true
            ),
            $this->makeFields(
                'input',
                'Slug<br><small>(p/ controle)</small>',
                'slug',
                true,
                null,
                true
            ),
            $this->makeFields('input', 'Rota', 'route', true),
            $this->makeFields('input', 'URI', 'uri', true),
            $this->makeFields('input', 'SEO<br>Título', 'page_title', true, null, true),
            $this->makeFields('image', 'SEO<br>Imagem', 'image', true, 'seo', true),
            $this->makeFields('text', 'SEO<br>Descrição', 'description'),
            $this->makeFields('text', 'SEO<br>Palavras Chave', 'keywords'),
        );
    }
}
