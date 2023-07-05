<?php

namespace Tests\Unit\Adm\Models;

use App\Models\Adm\NewsGalleryModel;
use Tests\TestCase;

class NewsGalleryModelTest extends TestCase
{
    public function testGetNewsGallery(): void
    {
        $newsGalleryModel = NewsGalleryModel::first();
        $title = $newsGalleryModel->title;
        $this->assertIsObject($newsGalleryModel);
        $this->assertIsString($title);
    }
}
