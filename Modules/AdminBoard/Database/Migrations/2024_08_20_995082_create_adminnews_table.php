<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminNewsTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('admin_news')) {
            Schema::create('admin_news', function (Blueprint $table) {
                $table->id();

                // add fields
                $table->string('uuid')->nullable();
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->longText('description')->nullable();
                $table->Text('short_description')->nullable();
                $table->text('photo')->nullable();
                $table->integer('order')->default(0);
                $table->string('status')->nullable();
                $table->bigInteger('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');

                $table->timestamps();
            });
        }
        if (! Schema::hasTable('admin_news_translations')) {
            Schema::create('admin_news_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->integer('admin_news_id');
                $table->string('name', 255)->nullable();
                $table->string('short_description', 400)->nullable();
                $table->longText('description')->nullable();
                $table->primary(['lang_code', 'admin_news_id'], 'admin_news_translations_primary');
            });
        }
        if (! Schema::hasTable('admin_new_categories')) {
            Schema::create('admin_new_categories', function (Blueprint $table) {
                $table->id();
                $table->integer('news_id')->unsigned()->references('id')->on('admin_news')->onDelete('cascade');
                $table->integer('category_id')->unsigned()->references('id')->on('admin_categories')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_news');
        Schema::dropIfExists('admin_news_translations');
        Schema::dropIfExists('admin_new_categories');
    }
};
