<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecoveriesSeeder extends Seeder
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
        DB::table('adm_recoveries')->insert([
            'id_user' => 1,
            'key' => 'chave',
            'date' => $dateNow,
            'expiration' => $dateNow,
            'used' => 0
        ]);
    }
}
