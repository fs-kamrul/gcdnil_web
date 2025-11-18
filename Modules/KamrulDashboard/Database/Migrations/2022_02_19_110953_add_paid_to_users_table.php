<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaidToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique();
            $table->bigInteger('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->boolean('is_admin')->default(1);
            $table->integer('allow_login')->default(1);
            $table->integer('business_id')->default(1);
            $table->text('photo')->nullable();
            $table->integer('status')->default(1);
//            $table->enum('status', ['active', 'inactive', 'terminated'])->default('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('role_id');
            $table->dropColumn('is_admin');
            $table->dropColumn('allow_login');
            $table->dropColumn('business_id');
            $table->dropColumn('photo');
            $table->dropColumn('status');
        });
    }
}
