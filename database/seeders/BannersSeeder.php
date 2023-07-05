<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_banners')->insert([
            'sort_order' => 1,
            'status' => 1,
            'title' => 'Banner 1',
            'image' => 'imagemBanner1.jpg',
            'text' => 'Texto incrível do banner 1',
            'link' => 'link do banner 1',
            'button_name' => 'Botão do banner 1'
        ]);
    }
}
