<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('site_institutional');
        Schema::create('site_institutional', function (Blueprint $table) {
            $table->id();
            $table->text('facebook')->nullable();
            $table->text('instagram')->nullable();
            $table->text('youtube')->nullable();
            $table->text('phone')->nullable();
            $table->text('wpp')->nullable();
            $table->text('wpp_text')->nullable();
            $table->text('address')->nullable();
            $table->text('google_maps_link')->nullable();
            $table->text('email')->nullable();
            $table->timestamps();
        });

        DB::table('site_institutional')->insert([
            'phone' => '(54) 99636-8858',
            'email' => 'contato@boulevardconvention.com',
            'instagram' => 'https://www.instagram.com/boulevardconvention/',
            'facebook' => 'https://www.facebook.com/boulevardconvention',
            'address' => 'R. Vinte, 199 - Garibaldina, Garibaldi - RS, 95720-000',
            'google_maps_link' => 'https://www.google.com.br/maps/place/R.+Vinte,+199+-+Garibaldina,+Garibaldi+-+RS,+95720-000/@-29.2113244,-51.5193079,17z/data=!3m1!4b1!4m5!3m4!1s0x951c3d3392826231:0x96daf7d611c43356!8m2!3d-29.2113244!4d-51.5193079?entry=ttu',
            'wpp' => '54996368858',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_institutional');
    }
};
