<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqCategoryTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('faq_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->tinyInteger('order')->default(0);
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });
        Schema::create('faq_categories_translations', function (Blueprint $table) {
            $table->string('lang_code');
            $table->integer('faq_categories_id');
            $table->string('name', 120)->nullable();

            $table->primary(['lang_code', 'faq_categories_id'], 'faq_categories_translations_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faq_categories');
        Schema::dropIfExists('faq_categories_translations');
    }
};
