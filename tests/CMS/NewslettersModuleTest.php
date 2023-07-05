<?php

namespace Tests\CMS;

use App\Models\Adm\AdmModel;
use App\Models\Adm\NewslettersModel;
use Tests\TestCase;

class NewslettersModuleTest extends TestCase
{
    public function testGetNewsletterModuleOneId()
    {
        $admModel = new AdmModel();
        $newsletterModel = NewslettersModel::first();
        $modelId = $newsletterModel->id;
        $admModel->changeTableNameForTests('site_newsletters');
        $get = $admModel->get(['id' => $modelId]);

        $this->assertIsObject($get);
        $this->assertSame($get->email, $newsletterModel['email']);
    }

    public function testGetNewsletterModuleAll()
    {
        $admModel = new AdmModel();
        $newsletterModel = NewslettersModel::all();
        $admModel->changeTableNameForTests('site_newsletters');
        $get = $admModel->get();

        $this->assertIsArray($get);
        $this->assertIsObject($newsletterModel);
        $this->assertSame(sizeof($newsletterModel), sizeof($get));
    }
}
