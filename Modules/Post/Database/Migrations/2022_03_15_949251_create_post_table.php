<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // add fields
            $table->string('uuid')->nullable();
            $table->string('name')->nullable();
            $table->string('header_title')->nullable();
            $table->text('icon_set')->nullable();
            $table->string('check_design')->nullable();
            $table->string('tag_line')->nullable();
            $table->date('start_date')->nullable();
            $table->string('set_time')->nullable();
            $table->string('slug')->nullable();
            $table->longText('description')->nullable();
            $table->Text('short_description')->nullable();
            $table->text('document_file')->nullable();
            $table->text('photo')->nullable();
            $table->integer('status')->default(1);
            $table->bigInteger('post_types_id')->unsigned()->nullable();
            $table->foreign('post_types_id')
                ->references('id')
                ->on('post_types');
//                ->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('designation')->nullable();

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
        Schema::dropIfExists('posts');
    }
};
