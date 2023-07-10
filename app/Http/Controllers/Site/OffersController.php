<?php

namespace App\Http\Controllers\Site;

use App\Models\Adm\OfferingsModule\OfferingsFilesModel;
use App\Models\Adm\OfferingsModule\OfferingsTextModel;

class OffersController extends SiteController
{
    public function index()
    {
        $this->data['texto'] = OfferingsTextModel::query()->first();
        $this->data['lista'] = OfferingsFilesModel::query()->where('status', 1)->orderBy('sort_order')->get();
        return view('site.pages.AppOffers.index', $this->data);
    }
}