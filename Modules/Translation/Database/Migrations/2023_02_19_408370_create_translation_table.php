<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();

            // add fields
            $table->integer('status')->default(0);
            $table->string('locale');
            $table->string('group');
            $table->string('key');
            $table->text('value')->nullable();

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
        Schema::dropIfExists('translations');
    }
};
