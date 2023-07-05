<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_news_gallery')->insert([
            'id_new' => 1,
            'sort_order' => 1,
            'highlighted' => 0,
            'title' => 'Título',
            'image' => 'image.jpg'
        ]);
    }
}
