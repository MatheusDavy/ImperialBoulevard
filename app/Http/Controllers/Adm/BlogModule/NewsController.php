<?php

namespace App\Http\Controllers\Adm\BlogModule;

use App\Http\Controllers\Adm\AdmController;
use App\Http\Controllers\Adm\Traits\FieldsTraits;
use App\Http\Controllers\Adm\Traits\ListFieldTraits;
use App\Models\Adm\BlogModule\NewsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends AdmController
{
    use ListFieldTraits;
    use FieldsTraits;

    public function __construct()
    {
        parent::__construct();
        $this->model = new NewsModel();
        $this->title = 'Notícia';
        $this->titlePlural = 'Notícias';
        $this->allowOrder = true;
        $this->allowStatus = true;
        $this->searchField = 'title';

        $this->listFields = array(
            $this->makeListFields('image', 'Imagem', 'image', 'small', 'noticias'),
            $this->makeListFields(null, 'Título', 'title', 'big', null, true, true),
            $this->makeListFields(null, 'Data', 'regular_date', 'small', null, false, true, 'date')
        );

        $this->fields['Dados'] = array(
        );

        $this->fields['Galeria'] = array(
            $this->galleryField('Galeria', 'gallery', 'noticias', false)
        );

        $categorias = DB::table('site_blog_categories')->get()->all();

        $this->data['categorias'] = $categorias;

        $autores = DB::table('site_blog_authors')->get()->all();

        foreach ($autores as $autor) {
            $autor->title = $autor->name;
        }

        $this->data['autores'] = $autores;
    }

    public function editar(Request $request, $id)
    {
        $post = NewsModel::find($id);
        if (!$post->text) {
            return parent::editar($request, $id);
        }
        if ($post->hash == null && $post->slug !== null) {
            $hash = hash('md5', $post->slug . $post->id);
            $url = route('site.draft', [$hash]);
            DB::table('site_news')->where('id', $id)->update(['hash' => $hash]);
            return $this->editar($request, $id);
        }

        $url = route('site.draft', [$post->hash]);

        $this->fields['Dados'] = array(
            $this->dateField('Data', 'date', true, true),
            $this->checkField('Ativo?', 'status', false, true),
            $this->ckEditorSimpleField('Título', 'title', true, true),
            $this->imageField('Imagem', 'image', 'noticias'),
            $this->selectField('select', 'Autores', 'id_author', 'autores', true, true),
            $this->selectField('select', 'Categorias', 'id_category', 'categorias', true, true),
            $this->customField([
                'type' => 'draftButton',
                'title' => 'Url <small>/draft/</small>',
                'name' => 'hash',
                'url' => $url,
                'disabled' => true,    
            ]),
            $this->slugField('slug', 'title'),
            $this->ckEditorField('Texto', 'text', true, false, 'noticias/conteudo'),
        );

        return parent::editar($request, $id);
    }
}
