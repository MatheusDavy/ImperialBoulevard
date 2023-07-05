<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('adm_companies')->insert([
            'phone' => '5670622947',
            'email' => 'noreply@weedev.com.br',
            'emails' => 'noreply@weedev.com.br',
            'facebook' => '',
            'instagram' => '',
            'social' => '',
            'analytics' => '',
            'gmaps' => 'https://maps.googleapis.com/maps/api/js',
            'address' => '',
            'position' => '-29.162867537152703,-51.17117968774414',
            'mail_host' => 'tls://mail.weedev.com.br',
            'mail_port' => '465',
            'mail_user' => 'noreply@weedev.com.br',
            'mail_pass' => 'TnKNgPtZWGO1',
            'mail_from' => 'noreply@weedev.com.br'
        ]);
    }
}
