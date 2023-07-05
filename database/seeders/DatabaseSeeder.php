<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Newsletters;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            InstitutionalSeeder::class,
            BannersSeeder::class,
            CompaniesSeeder::class,
            ContactsSeeder::class,
            ModulesSeeder::class,
            NewsSeeder::class,
            NewsGallerySeeder::class,
            NewslettersSeeder::class,
            PagesSeeder::class,
            PagesFieldsSeeder::class,
            PagesGallerySeeder::class,
            RecoveriesSeeder::class,
            SeoSeeder::class,
            UserGroupsSeeder::class,
            UsersSeeder::class,
        ]);
    }
}
