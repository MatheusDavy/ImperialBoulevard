<?php

namespace Tests\Unit\Adm\Models;

use App\Models\Adm\ModulesModel;
use Tests\TestCase;

class ModulesModelTest extends TestCase
{
    public function testGetModule(): void
    {
        $modulesModel = ModulesModel::find(1);
        $title = $modulesModel->title;

        $this->assertSame($title, 'Configuracoes');
    }
}
