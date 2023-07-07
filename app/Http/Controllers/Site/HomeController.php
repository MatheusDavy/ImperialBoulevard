<?php

namespace App\Http\Controllers\Site;

use App\Models\Adm\HomeModule\FifthSectionModel;
use App\Models\Adm\HomeModule\FirstSectionModel;
use App\Models\Adm\HomeModule\FourthSectionModel;
use App\Models\Adm\HomeModule\SecondSectionModel;
use App\Models\Adm\HomeModule\SeventhSectionModel;
use App\Models\Adm\HomeModule\SixthSectionModel;
use App\Models\Adm\HomeModule\ThirdSectionModel;
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
        $this->data['firstSection'] = FirstSectionModel::query()->first();
        $this->data['secondSection'] = SecondSectionModel::query()->first();
        $this->data['thirdSection'] = ThirdSectionModel::query()->first();
        $this->data['fourthSection'] = FourthSectionModel::query()->first();
        $this->data['fifthSection'] = FifthSectionModel::query()->first();
        $this->data['sixthSection'] = SixthSectionModel::query()->first();
        $this->data['seventhSection'] = SeventhSectionModel::query()->first();

        return view('site.pages.AppHome.index', $this->data);
    }
}
