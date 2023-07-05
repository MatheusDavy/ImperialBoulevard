<?php

namespace Tests\Unit\Adm\Models;

use App\Models\Adm\PagesFieldsModel;
use Tests\TestCase;

class PagesFieldsModelTest extends TestCase
{
    public function testGetPageFieldModel(): void
    {
        $pagesFieldsModel = PagesFieldsModel::find(1);
        $value = $pagesFieldsModel->value;

        $this->assertSame($value, "We''ve been Making Delicious Foods Since 1999");
    }
}
