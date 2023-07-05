<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

class ProjectMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adm_modules', function (Blueprint $table) {
            $table->id();
            $table->integer('sort_order')->unsigned()->default(0);
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->tinyInteger('parent')->unsigned()->nullable();
            $table->string('title');
            $table->string('url')->nullable();
            $table->string('route')->nullable();
            $table->string('icon')->nullable();
        });

        Schema::create('site_banners', function (Blueprint $table) {
            $table->id();
            $table->integer('sort_order')->unsigned()->default(0);
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->string('title')->nullable();
            $table->text('image')->nullable();
            $table->text('text')->nullable();
            $table->string('link')->nullable();
            $table->string('button_name')->nullable();
        });

        Schema::create('site_news', function (Blueprint $table) {
            $table->id();
            $table->integer('sort_order')->default(0);
            $table->smallInteger('status')->default(0);
            $table->date('date');
            $table->string('title');
            $table->string('slug')->unique()->nullable();
            $table->text('text');
            $table->text('image')->nullable();
            $table->text('image_mobile')->nullable();
            $table->text('image_thumb')->nullable();
            $table->integer('id_category')->unsigned()->nullable();
            $table->integer('id_author')->unsigned()->nullable();
            $table->string('hash')->nullable();
        });

        Schema::create('site_blog_authors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->string('bio', 500)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('image_mobile', 255)->nullable();
            $table->integer('sort_order')->default(0);
            $table->smallInteger('status')->default(0);
        });

        Schema::create('site_blog_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->integer('sort_order')->default(0);
            $table->smallInteger('status')->default(0);
        });

        Schema::create('adm_companies', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('emails')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('social')->nullable();
            $table->string('analytics')->nullable();
            $table->string('rd')->nullable();
            $table->string('gtm')->nullable();
            $table->string('recaptcha')->nullable();
            $table->string('recaptcha_secret')->nullable();
            $table->string('gmaps')->nullable();
            $table->text('address');
            $table->string('position')->nullable();
            $table->string('mail_host')->nullable();
            $table->string('mail_port')->nullable();
            $table->string('mail_user')->nullable();
            $table->string('mail_pass')->nullable();
            $table->string('mail_from')->nullable();
        });

        Schema::create('adm_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
        });

        Schema::create('adm_seo', function (Blueprint $table) {
            $table->id();
            $table->integer('sort_order')->unsigned()->default(0);
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->text('title')->nullable();
            $table->text('slug')->nullable();
            $table->text('route')->nullable();
            $table->text('page_title')->nullable();
            $table->text('uri')->nullable();
            $table->text('image')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
        });

        Schema::create('adm_users', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('id_group')->unsigned();
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->string('login', 55)->nullable();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('name');
            $table->text('image')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('remember_token')->index()->nullable();
            $table->text('two_factor_secret')
                    ->nullable();

            $table->text('two_factor_recovery_codes')
                    ->nullable();

            if (Fortify::confirmsTwoFactorAuthentication()) {
                $table->timestamp('two_factor_confirmed_at')
                        ->nullable();
            }
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });

        Schema::create('adm_roles', function (Blueprint $table) {
            $table->id();
            $table->string('role');
        });

        DB::table('adm_roles')->insert(
            ['role' => 'admin'],
        );

        Schema::create('adm_user_roles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_roles')->unsigned();
            $table->foreign('id_roles')
                ->references('id')
                ->on('adm_roles')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->integer('user')->unsigned();
        });

        Schema::create('adm_users_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('permissions', 500)->nullable();
        });

        Schema::create('site_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject')->default('');
            $table->text('message')->nullable();
            $table->dateTime('created');
        });

        Schema::create('site_newsletters', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->dateTime('created');
        });

        Schema::create('site_news_gallery', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_new')->unsigned();
            $table->foreign('id_new')
                ->references('id')
                ->on('site_news')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->integer('sort_order')->unsigned()->default(0);
            $table->smallInteger('highlighted')->unsigned()->default(0);
            $table->string('title')->nullable();
            $table->string('image')->nullable();
        });

        Schema::create('site_general_gallery', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('folder')->nullable();
            $table->string('column')->nullable();
            $table->string('table')->nullable();
            $table->string('module')->nullable();
            $table->tinyInteger('isGallery')->default(0);
            $table->tinyInteger('moduleId')->default(0)->nullable();
            $table->tinyInteger('isLang')->default(0);
            $table->tinyInteger('language')->default(1)->nullable();
            $table->string('foreignKey')->nullable();
        });

        Schema::create('adm_pages_gallery', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_page')->unsigned();
            $table->foreign('id_page')
                ->references('id')
                ->on('adm_pages')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->smallInteger('sort_order')->unsigned()->default(0);
            $table->tinyInteger('highlighted')->unsigned()->default(0);
            $table->string('title')->nullable();
            $table->string('image');
        });

        Schema::create('adm_recoveries', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->string('key');
            $table->date('date');
            $table->date('expiration');
            $table->smallInteger('used')->default(0);
        });

        Schema::create('adm_pages_fields', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_page')->unsigned();
            $table->foreign('id_page')
                ->references('id')
                ->on('adm_pages')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('type');
            $table->string('title');
            $table->tinyInteger('half')->unsigned()->default(0);
            $table->text('value')->nullable();
        });

        Schema::create('site_institutional', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->text('image')->nullable();
        });

        Schema::create('site_cache', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->tinyInteger('status')->default(0);
        });

        DB::table('site_cache')->insert([
            'id' => 1,
            'title' => 'Cache'
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
        Schema::dropIfExists('adm_pages_fields');
        Schema::dropIfExists('adm_recoveries');
        Schema::dropIfExists('adm_pages_gallery');
        Schema::dropIfExists('site_news_gallery');
        Schema::dropIfExists('site_newsletters');
        Schema::dropIfExists('site_contacts');
        Schema::dropIfExists('adm_users_groups');
        Schema::dropIfExists('adm_users');
        Schema::dropIfExists('adm_seo');
        Schema::dropIfExists('adm_pages');
        Schema::dropIfExists('adm_companies');
        Schema::dropIfExists('site_news');
        Schema::dropIfExists('site_banners');
        Schema::dropIfExists('adm_modules');
        Schema::dropIfExists('site_general_gallery');
    }
}
