<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminWorkshopTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('admin_workshops')) {
            Schema::create('admin_workshops', function (Blueprint $table) {
                $table->id();

                // add fields
                $table->string('uuid')->nullable();
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->longText('description')->nullable();
                $table->text('short_description')->nullable();
                $table->text('photo')->nullable();
                $table->string('set_time')->nullable();
                $table->string('start_date')->nullable();
                $table->string('location')->nullable();
                $table->integer('order')->default(0);
                $table->string('status')->nullable();
                $table->bigInteger('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');

                $table->timestamps();
            });
        }
        if (! Schema::hasTable('admin_workshops_translations')) {
            Schema::create('admin_workshops_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->integer('admin_workshops_id');
                $table->string('name', 255)->nullable();
                $table->string('short_description', 400)->nullable();
                $table->longText('description')->nullable();
                $table->primary(['lang_code', 'admin_workshops_id'], 'admin_workshops_translations_primary');
            });
        }
        if (! Schema::hasTable('admin_workshop_categories')) {
            Schema::create('admin_workshop_categories', function (Blueprint $table) {
                $table->id();
                $table->integer('workshop_id')->unsigned()->references('id')->on('admin_workshops')->onDelete('cascade');
                $table->integer('category_id')->unsigned()->references('id')->on('admin_categories')->onDelete('cascade');
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
        Schema::dropIfExists('admin_workshops');
        Schema::dropIfExists('admin_workshops_translations');
        Schema::dropIfExists('admin_workshop_categories');
    }
};
