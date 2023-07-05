<?php

namespace Tests\Unit\Adm\Models;

use App\Models\Adm\CompaniesModel;
use Tests\TestCase;

class CompaniesModelTest extends TestCase
{
    public function testGetCompanie(): void
    {
        $companiesModel = CompaniesModel::find(1);
        $email = $companiesModel->email;

        $this->assertSame($email, 'noreply@weedev.com.br');
    }
}
