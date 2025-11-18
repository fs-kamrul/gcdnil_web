<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionSubjectTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('admission_subjects', function (Blueprint $table) {
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
//        Schema::create('admission_marks', function (Blueprint $table) {
//            $table->id();
//
//            // add fields
//            $table->integer('admission_subjects_id')->nullable();
//            $table->integer('admissions_id')->nullable();
//            $table->string('name')->nullable();
//            $table->double('mark')->default(0);
//            $table->bigInteger('user_id')->unsigned();
//            $table->foreign('user_id')->references('id')->on('users');
//
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admission_subjects');
//        Schema::dropIfExists('admission_marks');
    }
};
