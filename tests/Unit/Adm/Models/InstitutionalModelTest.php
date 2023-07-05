<?php

namespace Tests\Unit\Adm\Models;

use App\Models\Adm\InstitutionalModel;
use Tests\TestCase;

class InstitutionalModelTest extends TestCase
{
    public function testGetInstitutional(): void
    {
        $institutionalModel = InstitutionalModel::first();
        $title = $institutionalModel->title;

        $this->assertSame($title, "We''ve been Making Delicious Foods Since 1999");
    }
}
