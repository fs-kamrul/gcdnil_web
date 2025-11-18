<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminNoticeBoardTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('admin_notice_boards')) {
            Schema::create('admin_notice_boards', function (Blueprint $table) {
                $table->id();

                // add fields
                $table->string('uuid')->nullable();
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->longText('description')->nullable();
                $table->Text('short_description')->nullable();
                $table->Text('document')->nullable();
                $table->text('photo')->nullable();
                $table->integer('order')->default(0);
                $table->string('status')->nullable();
                $table->bigInteger('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');

                $table->timestamps();
            });
        }
        if (! Schema::hasTable('admin_notice_boards_translations')) {
            Schema::create('admin_notice_boards_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->integer('admin_notice_boards_id');
                $table->string('name', 255)->nullable();
                $table->string('short_description', 400)->nullable();
                $table->longText('description')->nullable();
                $table->primary(['lang_code', 'admin_notice_boards_id'], 'admin_notice_boards_translations_primary');
            });
        }
        if (! Schema::hasTable('admin_notice_board_categories')) {
            Schema::create('admin_notice_board_categories', function (Blueprint $table) {
                $table->id();
                $table->integer('notice_board_id')->unsigned()->references('id')->on('admin_notice_boards')->onDelete('cascade');
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
        Schema::dropIfExists('admin_notice_boards');
        Schema::dropIfExists('admin_notice_boards_translations');
        Schema::dropIfExists('admin_notice_board_categories');
    }
};
