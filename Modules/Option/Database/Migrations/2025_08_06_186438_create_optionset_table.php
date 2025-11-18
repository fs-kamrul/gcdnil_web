<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOptionSetTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('option_sets', function (Blueprint $table) {
            $table->id();

            // add fields
//            $table->string('uuid')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('subject_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('group_id')->nullable();
//            $table->longText('description')->nullable();
//            $table->Text('short_description')->nullable();
//            $table->text('photo')->nullable();
            $table->integer('selected_subjects')->default(1);
            $table->integer('order')->default(0);
            $table->string('status')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });
        if (! Schema::hasTable('option_set_subjects')) {
            Schema::create('option_set_subjects', function (Blueprint $table) {
                $table->id();
                $table->integer('set_id')->unsigned()->references('id')->on('option_sets')->onDelete('cascade');
                $table->integer('subject_id')->unsigned()->references('id')->on('option_subjects')->onDelete('cascade');
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
        Schema::dropIfExists('option_sets');
        Schema::dropIfExists('option_set_subjects');
    }
};
