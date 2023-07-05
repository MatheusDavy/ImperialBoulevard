<?php

namespace Tests\Unit\Adm\Models;

use App\Models\Adm\PagesGalleryModel;
use Tests\TestCase;

class PagesGalleryModelTest extends TestCase
{
    public function testGetPageGalleryModel(): void
    {
        $pagesGalleryModel = PagesGalleryModel::find(1);
        $title = $pagesGalleryModel->title;

        $this->assertSame($title, "Título");
    }
}
