<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostGalleryParameterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_gallery_parameters', function (Blueprint $table) {
            $table->id();
//            $table->integer('category_id')->unsigned()->references('id')->on('categories')->onDelete('cascade');
            $table->bigInteger('post_gallery_id')->unsigned()->index();
            $table->foreign('post_gallery_id')
                ->references('id')
                ->on('post_galleries')
                ->onDelete('cascade');
            $table->bigInteger('post_id')->unsigned()->index();
            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->onDelete('cascade');
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
        Schema::dropIfExists('post_gallery_parameters');
    }
}
