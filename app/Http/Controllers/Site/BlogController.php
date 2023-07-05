<?php

namespace App\Http\Controllers\Site;

use App\Models\Adm\BlogModule\NewsModel;
use Carbon\Carbon;
class BlogController extends SiteController
{
    public function index()
    {
        $today = Carbon::now()->toDateString();
        $posts = NewsModel::where('status', 1)
                    ->where('date', '<=', $today)
                    ->get()
                    ->all();

        $this->data['posts'] = $posts;
        return view('site.pages.AppBlog.index', $this->data);
    }

    public function detail($slug)//Página de detalhe do post
    {
        $today = Carbon::now()->toDateString(); // Data de Hoje
        $post = NewsModel::where('slug', $slug) //(1) Pega post com o mesmo slug
                    ->where('status', 1) //(2) com status ativo
                    ->where('date', '<=', $today) //(3) Com a data de hoje ou mais antigo
                    ->first();

        if(!$post) abort(404); //Se o post não bater com as 3 verificações vai para 404

        $this->data['post'] = $post;
        return view('site.pages.AppBlogDetail.index', $this->data); //Se passar pelas três verificações e o Post existir
    }

    public function draft($hash)
    {
        $this->data['categories'] = $this->getCategories();
        $post = NewsModel::getPostDraft($hash);
        $this->data['post'] = $post;
        $this->getPostSeo($post);
        return view('site.pages.AppBlogDetail.index', $this->data);
    }
}
