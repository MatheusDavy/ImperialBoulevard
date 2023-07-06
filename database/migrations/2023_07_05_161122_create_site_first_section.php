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
        Schema::create('site_first_section', function (Blueprint $table) {
            $table->id();
            $table->text('above_title')->nullable();
            $table->text('title')->nullable();
            $table->text('location')->nullable();
            $table->text('subtitle')->nullable();
            $table->text('image')->nullable();
            $table->text('image_mobile')->nullable();
            $table->text('button_title')->nullable();
            $table->text('button_link')->nullable();
            $table->timestamps();
        });

        Schema::create('site_second_section', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->text('image_top')->nullable();
            $table->text('image_top_mobile')->nullable();
            $table->text('image_right')->nullable();
            $table->text('image_right_mobile')->nullable();
            $table->text('image_bottom')->nullable();
            $table->text('image_bottom_mobile')->nullable();
            $table->timestamps();
        });

        Schema::create('site_third_section', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->text('description')->nullable();
            $table->text('image_left')->nullable();
            $table->text('image_left_mobile')->nullable();
            $table->text('image_right')->nullable();
            $table->text('image_right_mobile')->nullable();
            $table->timestamps();
        });

        Schema::create('site_fourth_section', function (Blueprint $table) {
            $table->id();
            $table->text('description_1')->nullable();
            $table->text('image_1')->nullable();
            $table->text('image_1_mobile')->nullable();
            $table->text('description_2')->nullable();
            $table->text('title_2')->nullable();
            $table->text('subtitle_2')->nullable();
            $table->text('image_2')->nullable();
            $table->text('image_2_mobile')->nullable();
            $table->timestamps();
        });

        Schema::create('site_fifth_section', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('subtitle')->nullable();
            $table->timestamps();
        });

        Schema::create('site_fifth_section_gallery', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('sort_order')->unsigned()->default(0);
            $table->bigInteger('id_section')->unsigned();
            $table->foreign('id_section')
                ->references('id')
                ->on('site_fifth_section')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->tinyInteger('highlighted')->unsigned()->default(0);
            $table->text('title')->nullable();
            $table->text('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_first_section');
        Schema::dropIfExists('site_second_section');
        Schema::dropIfExists('site_third_section');
        Schema::dropIfExists('site_fourth_section');
        Schema::dropIfExists('site_fifth_section_gallery');
        Schema::dropIfExists('site_fifth_section');
    }
};
