<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->id();

            // add fields
            $table->string('email', 120);
            $table->string('name', 120)->nullable();
            $table->integer('product_id')->default(0);
            $table->string('status', 60)->default('Subscribed');
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
        Schema::dropIfExists('newsletters');
    }
};
