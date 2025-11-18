<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();

            // add fields
            $table->string('uuid')->nullable();
            $table->string('name')->nullable();
            $table->longText('description')->nullable();
            $table->text('short_description')->nullable();
            $table->text('photo')->nullable();
            $table->string('slug')->nullable();
            $table->bigInteger('page_templates_id')->unsigned()->nullable();
            $table->foreign('page_templates_id')
                ->references('id')
                ->on('page_templates');
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
        Schema::dropIfExists('pages');
    }
};
