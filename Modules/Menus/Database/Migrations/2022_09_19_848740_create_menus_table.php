<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('menuses', function (Blueprint $table) {
            $table->id();

            // add fields
            $table->string('uuid')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
//            $table->longText('description')->nullable();
//            $table->text('photo')->nullable();
            $table->integer('status')->default(1);
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });

        Schema::create('menus_nodes', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->bigInteger('menus_id')->unsigned();
            $table->foreign('menus_id')->references('id')->on('menuses')->onDelete('cascade');
//            $table->integer('menu_id')->unsigned()->index()->references('id')->on('menus');
            $table->integer('parent_id')->default(0)->unsigned()->index();
            $table->integer('sort')->default(0);
            $table->integer('depth')->default(0);
            $table->integer('reference_id')->unsigned()->nullable();
            $table->string('reference_type', 255)->nullable();
            $table->string('url', 120)->nullable();
            $table->string('icon_font', 50)->nullable();
            $table->tinyInteger('position')->unsigned()->default(0);
            $table->string('title', 120)->nullable();
            $table->string('css_class', 120)->nullable();
            $table->enum('target', ['_self', '_blank'])->default('_self');
            $table->tinyInteger('has_child')->unsigned()->default(0);
            $table->timestamps();
        });

        Schema::create('menus_locations', function (Blueprint $table) {
            $table->id();
            $table->integer('menus_id')->unsigned();
            $table->string('location', 120);
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
        Schema::dropIfExists('menus');
        Schema::dropIfExists('menus_nodes');
        Schema::dropIfExists('menus_locations');
    }
};
