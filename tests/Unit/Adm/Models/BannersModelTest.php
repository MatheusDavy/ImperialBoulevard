<?php

namespace Tests\Unit\Adm\Models;

use App\Models\Adm\BannersModel;
use Tests\TestCase;

class BannersModelTest extends TestCase
{
    public function testGetBanner(): void
    {
        $bannersModel = BannersModel::find(1);
        $title = $bannersModel->title;

        $this->assertSame($title, "Banner 1");
    }
}
