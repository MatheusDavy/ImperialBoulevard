<?php

namespace App\Http\Controllers\Site;

class ContactController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('site.pages.AppContact.index', $this->data);
    }
}
