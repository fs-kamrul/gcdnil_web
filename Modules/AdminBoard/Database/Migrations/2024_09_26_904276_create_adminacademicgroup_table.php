<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminAcademicGroupTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('admin_academic_groups')) {
            Schema::create('admin_academic_groups', function (Blueprint $table) {
                $table->id();

                // add fields
                $table->string('uuid')->nullable();
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->longText('description')->nullable();
                $table->Text('short_description')->nullable();
                $table->text('photo')->nullable();
                $table->integer('order')->default(0);
                $table->string('status')->nullable();
                $table->bigInteger('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');

                $table->timestamps();
            });
        }
        if (! Schema::hasTable('admin_academic_groups_translations')) {
            Schema::create('admin_academic_groups_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->integer('admin_academic_groups_id');
                $table->string('name', 255)->nullable();
                $table->primary(['lang_code', 'admin_academic_groups_id'], 'admin_academic_groups_translations_primary');
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
        Schema::dropIfExists('admin_academic_groups');
        Schema::dropIfExists('admin_academic_groups_translations');
    }
};
