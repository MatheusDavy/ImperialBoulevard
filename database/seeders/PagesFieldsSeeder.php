<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesFieldsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('adm_pages_fields')->insert([
            'id_page' => 1,
            'name' => 'title',
            'type' => 'input',
            'title' => 'Título',
            'half' => 0,
            'value' => "We''ve been Making Delicious Foods Since 1999"
        ]);

        DB::table('adm_pages_fields')->insert([
            'id_page' => 1,
            'name' => 'text',
            'type' => 'text',
            'title' => 'Texto',
            'half' => 0,
            'value' => 'Fusce hendrerit malesuada lacinia. Donec semper
            semper sem vitae malesuada. Proin scelerisque risus et ipsum
            semper molestie sed in nisi. Ut rhoncus congue lectus, rhoncus
            venenatis leo malesuada id. Sed elementum vel felis sed
            scelerisque. In arcu diam, sollicitudin eu nibh ac,
            posuere tristique magna.'
        ]);

        DB::table('adm_pages_fields')->insert([
            'id_page' => 1,
            'name' => 'image',
            'type' => 'image',
            'title' => 'Imagem',
            'half' => 1,
            'value' => 'acascacc.jpg'
        ]);

        DB::table('adm_pages_fields')->insert([
            'id_page' => 1,
            'name' => 'status',
            'type' => 'checkbox',
            'title' => 'Status',
            'half' => 1,
            'value' => 1
        ]);
    }
}
