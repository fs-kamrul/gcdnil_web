<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWidgetTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();

            // add fields
            $table->string('widget_id', 120);
            $table->string('sidebar_id', 120);
            $table->string('theme', 120);
            $table->tinyInteger('position')->unsigned()->default(0);
            $table->text('data')->nullable();

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
        Schema::dropIfExists('widgets');
    }
};
