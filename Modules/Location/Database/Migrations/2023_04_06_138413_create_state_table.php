<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStateTable extends Migration
//return new class extends Migration
{
    public function up()
    {

        if (! Schema::hasTable('states')) {
            Schema::create('states', function (Blueprint $table) {
                $table->id();
                $table->string('name', 120);
                $table->string('abbreviation', 3)->nullable();
                $table->integer('country_id')->unsigned()->nullable();
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
        Schema::dropIfExists('states');
    }
};
