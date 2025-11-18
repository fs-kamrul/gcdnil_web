<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwesomeIconTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('awesome_icons', function (Blueprint $table) {
            $table->id();

            // add fields
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('status')->default(1);
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
        Schema::dropIfExists('awesome_icons');
    }
};
