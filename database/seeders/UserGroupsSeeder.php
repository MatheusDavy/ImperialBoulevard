<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cacheId = DB::table('adm_modules')->where('title', 'Cache')->first()->id;
        $institutionalId = DB::table('adm_modules')->where('title', 'Institucional')->first()->id;
        $backupId = DB::table('adm_modules')->where('route', 'Backup')->first()->id;
        $logId = DB::table('adm_modules')->where('route', 'Log')->first()->id;
        DB::table('adm_users_groups')->insert([
            'title' => 'Administrador',
            'permissions' => "8|9|10|14|15|16|11|12|2|3|4|5|6|$cacheId|$institutionalId|$backupId|$logId"
        ]);
    }
}
