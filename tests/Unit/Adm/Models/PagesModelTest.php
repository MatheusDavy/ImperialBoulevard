<?php

namespace Tests\Unit\Adm\Models;

use App\Models\Adm\PagesModel;
use Tests\TestCase;

class PagesModelTest extends TestCase
{
    public function testGetPageModel(): void
    {
        $pagesModel = PagesModel::find(1);
        $slug = $pagesModel->slug;

        $this->assertSame($slug, "home-sobre");
    }
}
