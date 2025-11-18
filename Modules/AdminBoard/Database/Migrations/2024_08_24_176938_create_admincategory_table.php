<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminCategoryTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('admin_categories')) {
            Schema::create('admin_categories', function (Blueprint $table) {
                $table->id();

                // add fields
                $table->string('name', 120);
                $table->string('description', 400)->nullable();
                $table->string('status', 60)->default('published');
                $table->string('adminboard', 60)->nullable();
                $table->integer('order')->default(0)->unsigned();
                $table->bigInteger('parent_id')->default(0)->unsigned();
                $table->tinyInteger('is_default')->default(0);
//                $table->bigInteger('user_id')->unsigned();
//                $table->foreign('user_id')->references('id')->on('users');

                $table->timestamps();
            });
        }
        if (! Schema::hasTable('admin_categories_translations')) {
            Schema::create('admin_categories_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->integer('admin_categories_id');
                $table->string('name', 255)->nullable();
                $table->string('description', 400)->nullable();

                $table->primary(['lang_code', 'admin_categories_id'], 'admin_categories_translations_primary');
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
        Schema::dropIfExists('admin_categories');
        Schema::dropIfExists('admin_categories_translations');
    }
};
