<?php

namespace Tests\Unit\Adm\Models;

use App\Models\Adm\SeoModel;
use Tests\TestCase;

class SeoModelTest extends TestCase
{
    public function testGetSeoModel(): void
    {
        $seoModel = SeoModel::find(1);
        $title = $seoModel->title;

        $this->assertSame($title, "Geral");
    }
}
