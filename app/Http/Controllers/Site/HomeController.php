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

        $this->getMobileImages();

        return view('site.pages.AppHome.index', $this->data);
    }

    private function getMobileImages()
    {
        if (checkMobile()) {
            $this->data['secondSection']->image_top = $this->data['secondSection']->image_top_mobile;
            $this->data['secondSection']->image_right = $this->data['secondSection']->image_right_mobile;
            $this->data['secondSection']->image_bottom = $this->data['secondSection']->image_bottom_mobile;

            $this->data['thirdSection']->image_left = $this->data['thirdSection']->image_left_mobile;
            $this->data['thirdSection']->image_right = $this->data['thirdSection']->image_right_mobile;
            
            $this->data['fourthSection']->image_2 = $this->data['fourthSection']->image_2_mobile;

            $this->data['sixthSection']->image_left = $this->data['sixthSection']->image_left_mobile;
            $this->data['sixthSection']->image_right = $this->data['sixthSection']->image_right_mobile;

            $this->data['seventhSection']->image = $this->data['seventhSection']->image_mobile;
        }
    }
}
