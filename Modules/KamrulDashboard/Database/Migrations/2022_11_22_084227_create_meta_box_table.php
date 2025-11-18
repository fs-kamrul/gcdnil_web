<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaBoxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_boxes', function (Blueprint $table) {
            $table->id();
            $table->string('meta_key', 255);
            $table->text('meta_value');
            $table->integer('reference_id')->unsigned();
            $table->string('reference_type', 255);
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
        Schema::dropIfExists('meta_boxes');
    }
}
