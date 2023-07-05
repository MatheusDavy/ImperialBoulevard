<?php

namespace Tests\Unit\Adm\Models;

use App\Models\Adm\UsersModel;
use Tests\TestCase;

class UsersModelTest extends TestCase
{
    public function testGetUsersModel(): void
    {
        $usersModel = UsersModel::find(1);
        $login = $usersModel->login;

        $this->assertSame($login, "weecom");
    }
}
