<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('site_sixth_section', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->text('button_text')->nullable();
            $table->text('button_link')->nullable();
            $table->text('image_left')->nullable();
            $table->text('image_left_mobile')->nullable();
            $table->text('image_right')->nullable();
            $table->text('image_right_mobile')->nullable();
            $table->timestamps();
        });

        Schema::create('site_seventh_section', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->text('image_mobile')->nullable();
            $table->text('button_text')->nullable();
            $table->text('button_link')->nullable();
            $table->timestamps();
        });

        Schema::table('site_newsletters', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->text('message')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
