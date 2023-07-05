<?php

namespace Tests\CMS;

use App\Models\Adm\AdmModel;
use App\Models\Adm\NewsModel;
use Tests\TestCase;

class NewsModuleTest extends TestCase
{
    public function testGetNewsModuleOneId()
    {
        $admModel = new AdmModel();
        $newsModel = NewsModel::first();
        $modelId = $newsModel->id;
        $admModel->changeTableNameForTests('site_news');
        $get = $admModel->get(['id' => $modelId]);

        $this->assertIsObject($get);
        $this->assertSame($get->title, $newsModel['title']);
    }

    public function testGeNewsModuleAll()
    {
        $admModel = new AdmModel();
        $newsModel = NewsModel::all();
        $admModel->changeTableNameForTests('site_news');
        $get = $admModel->get();

        $this->assertIsArray($get);
        $this->assertIsObject($newsModel);
        $this->assertSame(sizeof($newsModel), sizeof($get));
    }

    public function testUpdateNewsModule()
    {
        $data = [
            "language" => [],
            "date" => "2022-04-12",
            "status" => "1",
            "title" => "Update 1",
            "slug" => "noticia-1",
            "text" => "<p>texto</p><p><strong>notícia</strong></p>",
            "gallery" => [
              "title" => [
                0 => "Título emocionante"
              ],
              "highlighted" => [
                0 => "0"
              ],
              "image" => [
                0 => "image.jpg"
              ]
            ]
        ];
        $newsModel = NewsModel::first();
        $admModel = new AdmModel();
        $admModel->changeTableNameForTests('site_news');
        $admModel->changeGalleryNameForTests('site_news_gallery');
        $admModel->changeForeignKeyForTests('id_new');

        #update
        $update = $admModel->update($newsModel->id, $data);

        #rollback
        $newsModel = NewsModel::first();
        $newsModel->title = 'Notícia 1';
        $newsModel->save();

        $this->assertTrue($update);
        $this->assertSame($newsModel->title, 'Notícia 1');
        $this->assertNotSame($newsModel->getOriginal('title'), $data['title']);
    }

    public function testInsertNewsModule()
    {
        $data = [
            "language" => [],
            "date" => "2022-04-12",
            "status" => "1",
            "title" => "Notícia 3",
            "slug" => "noticia-3",
            "text" => "<p>adaawdwaw</p>",
            "gallery" => [
              "title" => [
                0 => null
              ],
              "highlighted" => [
                0 => "0"
              ],
              "image" => [
                0 => "16497946766255de74b5160.jpg"
              ]
              ],
            "sort_order" => 3
          ];

        $admModel = new AdmModel();
        $admModel->changeTableNameForTests('site_news');
        $admModel->changeGalleryNameForTests('site_news_gallery');
        $admModel->changeForeignKeyForTests('id_new');

        #insert
        $insert = $admModel->insert($data);
        $newsModel = NewsModel::find($insert);

        $this->assertIsObject($newsModel);
        $this->assertSame($newsModel->title, "Notícia 3");
        $newsModel->delete($insert);
    }
}
