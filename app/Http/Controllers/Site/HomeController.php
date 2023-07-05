<?php

namespace App\Http\Controllers\Site;

use App\Models\Site\CommonModel;

class HomeController extends SiteController
{
    public CommonModel $commonModel;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('site.pages.AppHome.index', $this->data);
    }
}
