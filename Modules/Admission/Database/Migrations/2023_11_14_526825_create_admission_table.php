<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionTable extends Migration
//return new class extends Migration
{
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();

            // add fields
            $table->string('uuid')->nullable();
            $table->string('name')->nullable();
            $table->string('student_id')->nullable();
            $table->string('bl_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('slug')->nullable();
            $table->text('photo')->nullable();
            $table->integer('nationality')->nullable();
            $table->string('birth_registration')->nullable();

            $table->string('roll')->nullable();
            $table->string('father_name')->nullable();
            $table->string('bl_father_name')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('mother_nane')->nullable();
            $table->string('bl_mother_nane')->nullable();
            $table->string('mother_phone')->nullable();
            $table->date('dob')->nullable();
            $table->integer('blood_group')->nullable();
            $table->integer('religion')->nullable();
            $table->integer('gender')->nullable();
            $table->integer('class')->nullable();
            $table->integer('year')->nullable();
            $table->integer('admission_group')->nullable();

            $table->string('pre_institution')->nullable();
            $table->integer('pre_class')->nullable();
            $table->string('pre_gpa')->nullable();

            $table->string('ssc_board')->nullable();
            $table->string('ssc_year')->nullable();
            $table->string('ssc_roll')->nullable();
            $table->integer('ssc_group')->nullable();
            $table->string('ssc_registration')->nullable();
            $table->string('ssc_gpa')->nullable();
            $table->string('ssc_transcript')->nullable();
            $table->string('ssc_testimonial')->nullable();

            $table->string('pre_address')->nullable();
            $table->string('pre_postcode')->nullable();
            $table->integer('pre_country')->nullable();
            $table->integer('pre_states')->nullable();
            $table->integer('pre_city')->nullable();
            $table->string('per_address')->nullable();
            $table->string('per_postcode')->nullable();
            $table->integer('per_country')->nullable();
            $table->integer('per_states')->nullable();
            $table->integer('per_city')->nullable();
            $table->string('loc_name')->nullable();
            $table->string('loc_phone')->nullable();
            $table->string('loc_relation')->nullable();
            $table->string('loc_address')->nullable();
            $table->string('loc_postcode')->nullable();

            $table->integer('status')->default(1);
            $table->integer('admission_merits_id')->nullable();
            $table->double('mark')->default(0);
            $table->string('tex_id')->nullable();
            $table->text('payment_img')->nullable();

            $table->string('payment_amount')->nullable();
            $table->string('payment_status')->default('due');

//            $table->bigInteger('user_id')->unsigned();
//            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });
        if (! Schema::hasTable('admission_set_subjects')) {
            Schema::create('admission_set_subjects', function (Blueprint $table) {
                $table->id();
                $table->integer('admission_id')->unsigned()->references('id')->on('admissions')->onDelete('cascade');
                $table->integer('set_id')->unsigned()->references('id')->on('option_sets')->onDelete('cascade');
                $table->integer('subject_id')->unsigned()->references('id')->on('option_subjects')->onDelete('cascade');
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
        Schema::dropIfExists('admissions');
        Schema::dropIfExists('admission_set_subjects');
    }
};
