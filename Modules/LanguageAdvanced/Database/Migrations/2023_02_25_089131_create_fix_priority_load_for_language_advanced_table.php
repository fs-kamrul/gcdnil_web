<?php

use Illuminate\Database\Migrations\Migration;
use Modules\LanguageAdvanced\Packages\Supports\Plugin;

class CreateFixPriorityLoadForLanguageAdvancedTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Plugin::activated();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
