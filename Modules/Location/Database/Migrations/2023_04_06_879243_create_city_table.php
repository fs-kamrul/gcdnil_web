<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityTable extends Migration
//return new class extends Migration
{
    public function up()
    {

        if (! Schema::hasTable('cities')) {
            Schema::create('cities', function (Blueprint $table) {
                $table->id();
                $table->string('name', 120);
                $table->integer('state_id')->unsigned();
                $table->integer('country_id')->unsigned()->nullable();
                $table->string('record_id', 40)->nullable();
                $table->tinyInteger('order')->default(0);
                $table->tinyInteger('is_default')->unsigned()->default(0);
                $table->string('status', 60)->default('1');
                $table->timestamps();
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
        Schema::dropIfExists('cities');
    }
};
