<?php

namespace Tests\Unit\Adm\Models;

use App\Models\Adm\NewslettersModel;
use Tests\TestCase;

class NewslettersModelTest extends TestCase
{
    public function testGetNewsletter(): void
    {
        $newsletterModel = NewslettersModel::find(2);
        $email = $newsletterModel->email;

        $this->assertSame($email, '41claudir@gmail.com');
    }

    public function testInsertNewsModule()
    {
        $newsletterModel = new NewslettersModel();

        $newsletterModel->name = 'Teste';
        $newsletterModel->email = 'Testefesfefes@email.com';
        $newsletterModel->created = '2022-04-12 15:43:23';

        $newsletterModel->save();

        $insertTest = NewslettersModel::where('email', 'Testefesfefes@email.com')->first();

        $this->assertIsObject($insertTest);
        $this->assertSame($insertTest->email, "Testefesfefes@email.com");
        $newsletterModel->delete($insertTest->id);
    }
}
