<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThemeIconTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('theme_icons', function (Blueprint $table) {
            $table->id();

            // add fields
            $table->string('uuid')->nullable();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->text('photo')->nullable();
            $table->integer('status')->default(1);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('theme_icons');
    }
};
