<?php

namespace Tests\Unit\Adm\Models;

use App\Models\Adm\UsersGroupsModel;
use Tests\TestCase;

class UsersGroupsModelTest extends TestCase
{
    public function testGetUsersGroupsModel(): void
    {
        $usersGroupsModel = UsersGroupsModel::find(1);
        $title = $usersGroupsModel->title;

        $this->assertSame($title, "Administrador");
    }
}
