<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionSslCommerceTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('admission_ssl_payment', function (Blueprint $table) {
            $table->id();

            $table->string('tran_id')->nullable()->unique();
            $table->string('val_id')->nullable()->unique();
            $table->string('student_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('inv_uuid')->nullable();
            $table->string('payment_type')->nullable();
            $table->tinyInteger('status')->default(0);

            $table->timestamps();
        });
        Schema::create('admission_ssl_commerces', function (Blueprint $table) {
            $table->id();

            // add fields
            $table->string('student_id')->nullable();
            $table->string('status')->nullable();
            $table->string('tran_date')->nullable();
            $table->string('tran_id')->nullable();
            $table->string('message')->nullable();
            $table->string('val_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('store_amount')->nullable();
            $table->string('currency')->nullable();
            $table->string('bank_tran_id')->nullable();
            $table->string('card_type')->nullable();
            $table->string('card_no')->nullable();
            $table->string('card_issuer')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_issuer_country')->nullable();
            $table->string('card_issuer_country_code')->nullable();
            $table->string('currency_type')->nullable();
            $table->string('currency_amount')->nullable();
            $table->string('currency_rate')->nullable();
            $table->string('base_fair')->nullable();
            $table->string('emi_instalment')->nullable();
            $table->string('emi_amount')->nullable();
            $table->string('emi_description')->nullable();
            $table->string('emi_issuer')->nullable();
            $table->string('risk_title')->nullable();
            $table->string('risk_level')->nullable();
            $table->string('discount_percentage')->nullable();
            $table->string('discount_remarks')->nullable();
            $table->string('discount_amount')->nullable();
            $table->string('validated_on')->nullable();
            $table->string('inv_uuid')->nullable();

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
        Schema::dropIfExists('admission_ssl_payment');
        Schema::dropIfExists('admission_ssl_commerces');
    }
};
