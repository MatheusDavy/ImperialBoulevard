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
        Schema::create('site_first_section_gallery', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('sort_order')->unsigned()->default(0);
            $table->bigInteger('id_section')->unsigned();
            $table->foreign('id_section')
                ->references('id')
                ->on('site_first_section')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->tinyInteger('highlighted')->unsigned()->default(0);
            $table->text('title')->nullable();
            $table->text('image')->nullable();
            $table->timestamps();
        });

        Schema::table('site_second_section', function (Blueprint $table) {
            $table->text('above_title')->nullable();
        });

        Schema::table('site_third_section', function (Blueprint $table) {
            $table->text('above_title')->nullable();
        });

        Schema::table('site_sixth_section', function (Blueprint $table) {
            $table->text('above_title')->nullable();
        });

        Schema::table('site_seventh_section', function (Blueprint $table) {
            $table->text('above_title')->nullable();
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
