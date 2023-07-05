<?php

namespace Tests\Unit\Adm\Models;

use App\Models\Adm\RecoveriesModel;
use Tests\TestCase;

class RecoveriesModelTest extends TestCase
{
    public function testGetRecoveriesModel(): void
    {
        $recoveriesModel = RecoveriesModel::find(1);
        $key = $recoveriesModel->key;

        $this->assertSame($key, "chave");
    }
}
