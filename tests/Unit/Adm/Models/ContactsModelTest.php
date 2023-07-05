<?php

namespace Tests\Unit\Adm\Models;

use App\Models\Adm\ContactsModel;
use Tests\TestCase;

class ContactsModelTest extends TestCase
{
    public function testGetContact(): void
    {
        $contactsModel = ContactsModel::find(1);
        $message = $contactsModel->message;

        $this->assertSame($message, 'HEY');
    }
}
