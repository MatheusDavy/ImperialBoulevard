<?php

namespace Tests\CMS;

use App\Models\Adm\AdmModel;
use App\Models\Adm\ContactsModel;
use Tests\TestCase;

class ContactModuleTest extends TestCase
{
    public function testGetContactModuleOneId()
    {
        $admModel = new AdmModel();
        $ContactModel = ContactsModel::first();
        $modelId = $ContactModel->id;
        $admModel->changeTableNameForTests('site_Contacts');
        $get = $admModel->get(['id' => $modelId]);

        $this->assertIsObject($get);
        $this->assertSame($get->name, $ContactModel['name']);
    }

    public function testGetContactModuleAll()
    {
        $admModel = new AdmModel();
        $contactModel = ContactsModel::all();
        $admModel->changeTableNameForTests('site_Contacts');
        $get = $admModel->get();

        $this->assertIsArray($get);
        $this->assertIsObject($contactModel);
        $this->assertSame(sizeof($contactModel), sizeof($get));
    }

    public function testInsertConstact()
    {
        $contactsModel = new ContactsModel();

        $contactsModel->name = 'Teste';
        $contactsModel->email = 'Testefesfefes@email.com';
        $contactsModel->subject = 'subject';
        $contactsModel->message = 'HAAAAgefef';
        $contactsModel->created = '2022-04-12 15:43:23';

        $contactsModel->save();

        $insertTest = ContactsModel::where('email', 'Testefesfefes@email.com')->first();

        $this->assertIsObject($insertTest);
        $this->assertSame($insertTest->message, "HAAAAgefef");
        $contactsModel->delete($insertTest->id);
    }
}
