<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactFormTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('contact_forms', function (Blueprint $table) {
            $table->id();
            // add fields
//            $table->string('uuid')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('subject')->nullable();
            $table->string('organization')->nullable();
            $table->string('contact_data')->nullable();
            $table->string('contact_time')->nullable();
            $table->longText('content')->nullable();
            $table->integer('status', 60)->default('unread');
//            $table->bigInteger('user_id')->unsigned();
//            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });

        Schema::create('contact_form_replies', function (Blueprint $table) {
            $table->id();
            $table->longText('message');
            $table->bigInteger('contact_form_id')->unsigned();
            $table->foreign('contact_form_id')->references('id')->on('contact_forms');
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
        Schema::dropIfExists('contact_forms');
        Schema::dropIfExists('contact_form_replies');
    }
};
