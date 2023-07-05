<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactsSeeder extends Seeder
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

        DB::table('site_contacts')->insert([
            'name' => 'Rafa',
            'email' => 'rborges13795@gmail.com',
            'subject' => '',
            'message' => 'HEY',
            'created' => $dateNow
        ]);
    }
}
