<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminTeamTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        if (! Schema::hasTable('admin_teams')) {
            Schema::create('admin_teams', function (Blueprint $table) {
                $table->id();

                // add fields
                $table->string('uuid')->nullable();
                $table->string('name')->nullable();
                $table->string('slug')->nullable();
                $table->longText('description')->nullable();
                $table->Text('short_description')->nullable();
                $table->text('photo')->nullable();
                $table->string('index_no')->nullable();
                $table->string('designation')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('father_name')->nullable();
                $table->string('mother_name')->nullable();
                $table->string('dob')->nullable();
                $table->string('office_address')->nullable();
                $table->text('facebook_id')->nullable();
                $table->text('google_site')->nullable();
                $table->text('linkedin_id')->nullable();
                $table->integer('order')->default(0);
                $table->string('status')->nullable();
                $table->bigInteger('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');

                $table->timestamps();
            });
        }
        if (! Schema::hasTable('admin_teams_translations')) {
            Schema::create('admin_teams_translations', function (Blueprint $table) {
                $table->string('lang_code');
                $table->integer('admin_teams_id');
                $table->string('name', 255)->nullable();
                $table->string('designation')->nullable();
                $table->string('short_description', 400)->nullable();
                $table->longText('description')->nullable();
                $table->primary(['lang_code', 'admin_teams_id'], 'admin_teams_translations_primary');
            });
        }
        if (! Schema::hasTable('admin_team_categories')) {
            Schema::create('admin_team_categories', function (Blueprint $table) {
                $table->id();
                $table->integer('team_id')->unsigned()->references('id')->on('admin_teams')->onDelete('cascade');
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
        Schema::dropIfExists('admin_teams');
        Schema::dropIfExists('admin_teams_translations');
        Schema::dropIfExists('admin_team_categories');
    }
};
