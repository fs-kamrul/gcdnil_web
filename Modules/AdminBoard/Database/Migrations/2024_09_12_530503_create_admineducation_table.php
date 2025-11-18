<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminEducationTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('admin_educations')) {
            Schema::create('admin_educations', function (Blueprint $table) {
                $table->id();

                // add fields
                $table->string('uuid')->nullable();
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
//            $table->longText('description')->nullable();
//            $table->Text('short_description')->nullable();
//            $table->text('photo')->nullable();
                $table->integer('order')->default(0);
                $table->string('status')->nullable();
                $table->bigInteger('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');

                $table->timestamps();
            });
        }
        if (! Schema::hasTable('admin_educations_translations')) {
            Schema::create('admin_educations_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->integer('admin_educations_id');
                $table->string('name', 255)->nullable();
                $table->primary(['lang_code', 'admin_educations_id'], 'admin_educations_translations_primary');
            });
        }

        if (! Schema::hasTable('admin_educations_names')) {
            Schema::create('admin_educations_names', function (Blueprint $table) {
                $table->id();
                $table->integer('educations_id')->unsigned();
                $table->integer('reference_id')->unsigned();
                $table->string('reference_type', 255);
                $table->string('name_title', 255)->nullable();
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
        Schema::dropIfExists('admin_educations');
        Schema::dropIfExists('admin_educations_translations');
        Schema::dropIfExists('admin_educations_names');
    }
};
