<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('countries')) {
            Schema::create('countries', function (Blueprint $table) {
                $table->id();
                $table->string('name', 120);
                $table->string('nationality', 120)->nullable();
                $table->tinyInteger('order')->default(0);
                $table->tinyInteger('is_default')->unsigned()->default(0);
                $table->string('status', 60)->default('1');
                $table->string('code', 10)->nullable();
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
        Schema::dropIfExists('countries');
    }
};
