<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminPartnerTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('admin_partners', function (Blueprint $table) {
            $table->id();

            // add fields
            $table->string('uuid')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
//            $table->longText('description')->nullable();
//            $table->Text('short_description')->nullable();
            $table->text('photo')->nullable();
            $table->string('set_url')->nullable();
            $table->integer('order')->default(0);
            $table->string('status')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('admin_partners');
    }
};
