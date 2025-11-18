<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageTranslationsTable extends Migration
//return new class extends Migration create_page_translations
{
    public function up()
    {
        Schema::create('pages_translations', function (Blueprint $table) {

            $table->string('lang_code');
            $table->integer('pages_id');
            $table->string('name', 255)->nullable();
            $table->string('short_description', 400)->nullable();
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();

            $table->primary(['lang_code', 'pages_id'], 'pages_translations_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages_translations');
    }
};
