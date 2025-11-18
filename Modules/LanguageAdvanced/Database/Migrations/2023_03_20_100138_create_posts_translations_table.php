<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('posts_translations', function (Blueprint $table) {

            $table->string('lang_code');
            $table->integer('posts_id');
            $table->string('name', 255)->nullable();
            $table->string('short_description', 400)->nullable();
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();

            $table->primary(['lang_code', 'posts_id'], 'posts_translations_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts_translations');
    }
};
