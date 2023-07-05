<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesGallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('adm_pages_gallery')->insert([
            'id_page' => 1,
            'sort_order' => 1,
            'highlighted' => 1,
            'title' => 'Título',
            'image' => '#',
        ]);
    }
}
