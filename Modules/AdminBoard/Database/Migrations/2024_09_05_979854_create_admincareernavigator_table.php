<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminCareerNavigatorTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('admin_career_navigators')) {
            Schema::create('admin_career_navigators', function (Blueprint $table) {
                $table->id();

                // add fields
                $table->string('uuid')->nullable();
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->longText('description')->nullable();
                $table->Text('short_description')->nullable();
                $table->text('photo')->nullable();
                $table->text('document')->nullable();
                $table->string('start_date')->nullable();
                $table->integer('order')->default(0);
                $table->string('status')->nullable();
                $table->bigInteger('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');

                $table->timestamps();
            });
        }
        if (! Schema::hasTable('admin_career_navigators_translations')) {
            Schema::create('admin_career_navigators_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->integer('admin_career_navigators_id');
                $table->string('name', 255)->nullable();
                $table->string('short_description', 400)->nullable();
                $table->longText('description')->nullable();
                $table->primary(['lang_code', 'admin_career_navigators_id'], 'admin_career_navigators_translations_primary');
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
        Schema::dropIfExists('admin_career_navigators');
        Schema::dropIfExists('admin_career_navigators_translations');
    }
};
