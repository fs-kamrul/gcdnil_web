<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminFacilityTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('admin_facilities')) {
            Schema::create('admin_facilities', function (Blueprint $table) {
                $table->id();

                // add fields
                $table->string('uuid')->nullable();
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->longText('description')->nullable();
                $table->Text('short_description')->nullable();
                $table->string('icon')->nullable();
                $table->text('photo')->nullable();
                $table->integer('order')->default(0);
                $table->string('status')->nullable();
                $table->bigInteger('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');

                $table->timestamps();
            });
        }
        if (! Schema::hasTable('admin_facilities_translations')) {
            Schema::create('admin_facilities_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->integer('admin_facilities_id');
                $table->string('name', 255)->nullable();
                $table->string('short_description', 400)->nullable();
                $table->longText('description')->nullable();
                $table->primary(['lang_code', 'admin_facilities_id'], 'admin_workshops_translations_primary');
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
        Schema::dropIfExists('admin_facilities');
        Schema::dropIfExists('admin_facilities_translations');
    }
};
