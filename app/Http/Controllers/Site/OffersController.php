<?php

namespace App\Http\Controllers\Site;

class OffersController extends SiteController
{
    public function index()
    {
        return view('site.pages.AppOffers.index', $this->data);
    }
}