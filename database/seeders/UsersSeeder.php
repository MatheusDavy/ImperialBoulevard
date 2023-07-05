<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('adm_users')->insert([
            'id_group' => 1,
            'status' => 1,
            'login' => 'weecom',
            'password' => Hash::make('weecom@_'),
            'email' => 'desenvolvimento@weecom.com.br',
            'name' => 'Weecom',
            'image' => '#'
        ]);
    }
}
