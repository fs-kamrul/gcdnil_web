<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaqTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->text('answer');
            $table->integer('category_id')->unsigned();
            $table->string('status', 60)->default('published');
            $table->timestamps();
        });
        Schema::create('faqs_translations', function (Blueprint $table) {
            $table->string('lang_code');
            $table->integer('faqs_id');
            $table->text('question')->nullable();
            $table->text('answer')->nullable();

            $table->primary(['lang_code', 'faqs_id'], 'faqs_translations_primary');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('faqs_translations');
    }
};
