<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('admin_galleries')) {
            Schema::create('admin_galleries', function (Blueprint $table) {
                $table->id();

                $table->string('name')->nullable();
                $table->bigInteger('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');

                $table->timestamps();
            });
        }
        if (!Schema::hasTable('admin_gallery_parameters')) {
            Schema::create('admin_gallery_parameters', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('gallery_id')->unsigned()->index();
                $table->foreign('gallery_id')
                    ->references('id')
                    ->on('admin_galleries')
                    ->onDelete('cascade');
                $table->bigInteger('reference_id')->unsigned()->index();
                $table->string('reference_type')->nullable();

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
        Schema::dropIfExists('admin_galleries');
        Schema::dropIfExists('admin_gallery_parameters');
    }
}
