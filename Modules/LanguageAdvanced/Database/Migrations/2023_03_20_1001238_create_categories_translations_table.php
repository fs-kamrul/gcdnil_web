<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('categories_translations', function (Blueprint $table) {

            $table->string('lang_code');
            $table->integer('categories_id');
            $table->string('name', 255)->nullable();
            $table->string('short_description', 400)->nullable();
            $table->longText('description')->nullable();

            $table->primary(['lang_code', 'categories_id'], 'categories_translations_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_translations');
    }
};
