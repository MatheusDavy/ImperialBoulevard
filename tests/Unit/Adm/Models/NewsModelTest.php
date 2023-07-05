<?php

namespace Tests\Unit\Adm\Models;

use App\Models\Adm\NewsModel;
use Tests\TestCase;

class NewsModelTest extends TestCase
{
    public function testGetNewsModel(): void
    {
        $newsModel = NewsModel::find(1);
        $title = $newsModel->title;

        $this->assertSame($title, 'Notícia 1');
    }
}
