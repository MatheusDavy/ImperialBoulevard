<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('adm_seo')->insert([
            'title' => 'Geral',
            'slug' => 'general',
            'route' => '-',
            'page_title' => 'Empresa',
            'sort_order' => 1,
            'status' => 1
        ]);

        DB::table('adm_seo')->insert([
            'title' => 'Home',
            'slug' => 'home',
            'route' => 'HomeController@index',
            'page_title' => 'Home',
            'uri' => '/',
            'sort_order' => 2,
            'status' => 1
        ]);
    }
}
