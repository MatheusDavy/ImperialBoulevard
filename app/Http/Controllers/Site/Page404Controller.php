<?php

namespace App\Http\Controllers\Site;

class Page404Controller extends SiteController
{
    public function index()
    {
        return view('site.pages.App404.index', $this->data);
    }
}
