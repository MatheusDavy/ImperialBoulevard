<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewslettersSeeder extends Seeder
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

        DB::table('site_newsletters')->insert([
            'name' => 'teste',
            'email' => 'teste@gmail.com',
            'created' => $dateNow
        ]);

        DB::table('site_newsletters')->insert([
            'name' => 'teste',
            'email' => 'teste.com',
            'created' => $dateNow
        ]);
    }
}
