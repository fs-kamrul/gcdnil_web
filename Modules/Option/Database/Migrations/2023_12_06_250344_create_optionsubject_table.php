<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionSubjectTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('option_subjects', function (Blueprint $table) {
            $table->id();

            // add fields
            $table->string('uuid')->nullable();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('slug')->nullable();
            $table->text('photo')->nullable();
            $table->integer('total_mark')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('order')->default(0);
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
        Schema::dropIfExists('option_subjects');
    }
};
