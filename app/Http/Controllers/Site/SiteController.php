<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Adm\CompaniesModel;
use Illuminate\Support\Facades\Route;
use App\Models\Site\CommonModel;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public $data = array();
    public $language;
    public CommonModel $commonModel;

    public function __construct()
    {
        try {
            session_start();
        } catch (\Throwable $th) {
            //throw $th;
        }

        date_default_timezone_set('America/Sao_Paulo');

        $this->commonModel = new CommonModel();

        $this->checkSeo();
        $this->checkLanguage();

        $this->language = _session('language');

        $lang = 'pt-br';

        if ($this->language == '1') {
            $lang = 'pt-br';
        } elseif ($this->language == '2') {
            $lang = 'en';
        } elseif ($this->language == '3') {
            $lang = 'es';
        }

        app()->setLocale($lang);
        $routeCurrent =  Route::current();
        if (!$routeCurrent) {
            show_404();
        }
        $routeParams = array_values(Route::current()->parameters());
        $company = CompaniesModel::first();

        $this->data['empresa'] = $company;
        $this->data['routeParams'] = $routeParams;
        $this->data['gtm'] = $company->gtm;
        $this->data['rd'] = $company->rd;
        $this->data['recaptcha'] = $company->recaptcha ? $company->recaptcha : '6LdOKt0ZAAAAABn0ttc7Cv4HgqbbsfxOPg7xDW8h';
    }

    public function checkSeo()
    {
        $this->data['metas'] = [];

        $seo = $this->commonModel->getSeo('general');

        $this->data['main_title'] = '';

        if ($seo) {
            $this->data['main_title'] = $seo->page_title;
            $this->data['metas']['keywords'] = $seo->keywords;
            $this->data['metas']['description'] = $seo->description;
            $this->data['metas']['og:description'] = $seo->description;

            try {
                $this->data['metas']['og:image'] = resize('userfiles/seo/' . $seo->image, 300, 300, 'canvas');
            } catch (\Throwable $th) {
                $this->data['metas']['og:image'] = asset('userfiles/seo/' . $seo->image);
            }
            $this->data['metas']['og:image:width'] = '300';
            $this->data['metas']['og:image:height'] = '300';

            //PEGA SEO DA PÁGINA ESPECIFICA
            $route = Route::currentRouteName();
            $route = explode('.', $route);

            if (count($route) == 2) {
                $pageSeo = $this->commonModel->getSeo($route[1]);
                if ($pageSeo) {
                    $this->data['title'] = $pageSeo->page_title;
                    if ($pageSeo->keywords) {
                        $this->data['metas']['keywords'] = $pageSeo->keywords;
                    }
                    if ($pageSeo->description) {
                        $this->data['metas']['description'] = $pageSeo->description;
                        $this->data['metas']['og:description'] = $pageSeo->description;
                    }
                    if ($pageSeo->image) {
                        try {
                            $this->data['metas']['og:image'] = resize('userfiles/seo/' . $pageSeo->image, 300, 300, 'canvas');
                        } catch (\Throwable $th) {
                            $this->data['metas']['og:image'] = asset('userfiles/seo/' . $seo->image);
                        }
                        $this->data['metas']['og:image:width'] = '300';
                        $this->data['metas']['og:image:height'] = '300';
                    }
                }
            }
        }

        return $this->data;
    }

    public function changeLang(Request $request)
    {
        $lang = $request->input('lang');
        if ($lang == 'pt-br' || $lang == 'pt') {
            $lang = '1';
        } elseif ($lang == 'en') {
            $lang = '2';
        } elseif ($lang == 'es') {
            $lang = '3';
        }
        $this->language = $lang;
        _session(['language' => $lang]);
        $json['status'] = true;
        echo json_encode($json);
        exit;
    }

    private function checkLanguage()
    {
        $languages = config('app.languages');
        $lang = _session('language');
        if (!$lang) {
            $lang = 'pt';
        }

        $route = Route::currentRouteName();
        $route = explode('.', $route);

        $langUrls = $languages;
        if ($lang == 'pt-br' || $lang == 'pt') {
            $lang = '1';
        } elseif ($lang == 'en') {
            $lang = '2';
        } elseif ($lang == 'es') {
            $lang = '3';
        }
        // dd($lang);
        $this->language = $lang;
        $this->data['language'] = $this->language;
        $this->data['languages'] = $languages;
        $this->data['langUrls'] = $langUrls;
    }
}
