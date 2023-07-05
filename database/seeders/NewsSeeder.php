<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dt = Carbon::now()->addHour(-3);
        $dateNow = $dt->toDateTimeString();

        DB::table('site_news')->insert([
            'sort_order' => 1,
            'status' => 1,
            'title' => 'Notícia 1',
            'slug' => 'noticia-1',
            'text' => '<p>texto</p><p><strong>notícia</strong></p>',
            'date' => $dateNow
        ]);

        DB::table('site_news')->insert([
            'sort_order' => 2,
            'status' => 1,
            'title' => 'Notícia 2',
            'slug' => 'noticia-2',
            'text' => '<p>lala</p>',
            'date' => $dateNow
        ]);

        DB::table('site_blog_authors')->insert([
            'id' => 1,
            'name' => 'Autor'
        ]);

        DB::table('site_blog_categories')->insert([
            'id' => 1,
            'title' => 'Geral'
        ]);
    }
}
