<?php

namespace Tests\CMS\Home;

use App\Models\Adm\AdmModel;
use App\Models\Adm\BannersModel;
use Tests\TestCase;

class BannerModuleTest extends TestCase
{
    public function testGetBannerModuleOneId()
    {
        $admModel = new AdmModel();
        $bannerModel = BannersModel::first();
        $modelId = $bannerModel->id;
        $admModel->changeTableNameForTests('site_banners');
        $get = $admModel->get(['id' => $modelId]);

        $this->assertIsObject($get);
        $this->assertSame($get->title, $bannerModel['title']);
    }

    public function testGetBannerModuleAll()
    {
        $admModel = new AdmModel();
        $bannerModel = BannersModel::all();
        $admModel->changeTableNameForTests('site_banners');
        $get = $admModel->get();

        $this->assertIsArray($get);
        $this->assertIsObject($bannerModel);
        $this->assertSame(sizeof($bannerModel), sizeof($get));
    }

    public function testUpdateBannerModule()
    {
        $data = [
            "language" => [],
            "status" => "1",
            "image" => "imagemBanner1.jpg",
            "title" => "Update 1",
            "text" => "Texto incrível do banner 1",
            "link" => "link do banner 1"
          ];

        $bannerModel = BannersModel::first();
        $admModel = new AdmModel();
        $admModel->changeTableNameForTests('site_banners');

        #update
        $update = $admModel->update($bannerModel->id, $data);

        #rollback
        $bannerModel = BannersModel::first();
        $bannerModel->title = 'Banner 1';
        $bannerModel->save();


        $this->assertTrue($update);
        $this->assertSame($bannerModel->title, 'Banner 1');
        $this->assertNotSame($bannerModel->getOriginal('title'), $data['title']);
    }

    public function testInsertBannerModule()
    {
        $data = [
            "language" => [],
            "status" => "1",
            "image" => "imagemBanner1.jpg",
            "title" => "Insert 2",
            "text" => "Texto incrível do banner 2",
            "link" => "link do banner 2"
          ];

        $admModel = new AdmModel();
        $admModel->changeTableNameForTests('site_banners');

        #insert
        $insert = $admModel->insert($data);
        $bannersModel = BannersModel::find($insert);

        $this->assertIsObject($bannersModel);
        $this->assertSame($bannersModel->title, "Insert 2");
        $bannersModel->delete($insert);
    }
}
