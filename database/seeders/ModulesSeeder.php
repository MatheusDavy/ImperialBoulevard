<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configId = DB::table('adm_modules')->insertGetId([
            'sort_order' => 6,
            'status' => 1,
            'title' => 'Configuracoes',
            'icon' => 'fa fa-cog',
        ]);

        DB::table('adm_modules')->insert([
            'parent' => $configId,
            'sort_order' => 1,
            'status' => 1,
            'title' => 'Grupos',
            'url' => 'configuracoes/grupos/',
            'route' => 'UsersGroups',
            'icon' => 'fa fa-users',
        ]);

        DB::table('adm_modules')->insert([
            'parent' => $configId,
            'sort_order' => 2,
            'status' => 1,
            'title' => 'Usuários',
            'url' => 'configuracoes/usuarios/',
            'route' => 'Users',
            'icon' => 'fa fa-user',
        ]);

        DB::table('adm_modules')->insert([
            'parent' => $configId,
            'sort_order' => 3,
            'status' => 1,
            'title' => 'Módulos',
            'url' => 'configuracoes/modulos/',
            'route' => 'Modules',
            'icon' => 'fa fa-list',
        ]);

        DB::table('adm_modules')->insert([
            'parent' => $configId,
            'sort_order' => 4,
            'status' => 1,
            'title' => 'Empresa',
            'url' => 'configuracoes/empresa/',
            'route' => 'Companies',
            'icon' => 'fa fa-warehouse',
        ]);

        DB::table('adm_modules')->insert([
            'parent' => $configId,
            'sort_order' => 5,
            'status' => 1,
            'title' => 'SEO',
            'url' => 'configuracoes/seo/',
            'route' => 'Seo',
            'icon' => 'fa fa-newspaper',
        ]);

        $homeId = DB::table('adm_modules')->insertGetId([
            'sort_order' => 1,
            'status' => 1,
            'title' => 'Home',
            'url' => '',
            'route' => '',
            'icon' => 'fa fa-home',
        ]);

        DB::table('adm_modules')->insert([
            'parent' => $homeId,
            'sort_order' => 1,
            'status' => 1,
            'title' => 'Banners',
            'url' => 'home/banners/',
            'route' => 'HomeModule\Banners',
            'icon' => 'fa fa-images',
        ]);

        DB::table('adm_modules')->insert([
            'parent' => $homeId,
            'sort_order' => 2,
            'status' => 1,
            'title' => 'Sobre',
            'url' => 'home/sobre/',
            'route' => 'Pages',
            'icon' => 'fa fa-align-left',
        ]);

        DB::table('adm_modules')->insert([
            'sort_order' => 4,
            'status' => 1,
            'title' => 'Newsletters',
            'url' => 'newsletters/',
            'route' => 'Newsletters',
            'icon' => 'fa fa-file-alt',
        ]);

        DB::table('adm_modules')->insert([
            'sort_order' => 5,
            'status' => 1,
            'title' => 'Contatos',
            'url' => 'contatos/',
            'route' => 'Contacts',
            'icon' => 'fa fa-user',
        ]);

        DB::table('adm_modules')->insert([
            'sort_order' => 3,
            'status' => 1,
            'title' => 'Galeria',
            'url' => 'galeria-geral/',
            'route' => 'Gallery',
            'icon' => 'fa fa-images',
        ]);

        $blogId = DB::table('adm_modules')->insertGetId([
            'sort_order' => 1,
            'status' => 1,
            'title' => 'Blog',
            'url' => '',
            'route' => '',
            'icon' => 'fa fa-newspaper',
        ]);

        DB::table('adm_modules')->insert([
            'parent' => $blogId,
            'sort_order' => 1,
            'status' => 1,
            'title' => 'Posts',
            'url' => 'blog/posts/',
            'route' => 'BlogModule\News',
            'icon' => 'fa fa-newspaper',
        ]);

        DB::table('adm_modules')->insert([
            'parent' => $blogId,
            'sort_order' => 2,
            'status' => 1,
            'title' => 'Autores',
            'url' => 'blog/autores/',
            'route' => 'BlogModule\Authors',
            'icon' => 'fa fa-user',
        ]);

        DB::table('adm_modules')->insert([
            'parent' => $blogId,
            'sort_order' => 2,
            'status' => 1,
            'title' => 'Categorias',
            'url' => 'blog/categorias/',
            'route' => 'BlogModule\Categories',
            'icon' => 'fa fa-warehouse',
        ]);

        DB::table('adm_modules')->insert([
            'sort_order' => 3,
            'status' => 1,
            'title' => 'Cache',
            'url' => 'cache/',
            'route' => 'Cache',
            'icon' => 'fa-solid fa-rotate',
        ]);

        DB::table('adm_modules')->insert([
            'sort_order' => 4,
            'status' => 1,
            'title' => 'Institucional',
            'url' => 'institucional/',
            'route' => 'Institutional',
            'icon' => 'fa fa-file-alt',
        ]);

        DB::table('adm_modules')->insert([
            'parent' => $configId,
            'sort_order' => 3,
            'status' => 1,
            'title' => 'Backup',
            'url' => 'backup/',
            'route' => 'Backup',
            'icon' => 'fa fa-file-alt',
        ]);

        DB::table('adm_modules')->insert([
            'parent' => $configId,
            'sort_order' => 4,
            'status' => 1,
            'title' => 'Logs',
            'url' => 'logs/',
            'route' => 'Log',
            'icon' => 'fa fa-file-alt',
        ]);
    }
}
