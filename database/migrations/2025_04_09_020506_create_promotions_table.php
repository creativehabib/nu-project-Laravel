<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('post_name');
            $table->string('pf_no');
            $table->string('present_designation');
            $table->string('department');
            $table->string('applicant_name');
            $table->string('applicant_name_bn');
            $table->string('father_name');
            $table->string('father_name_bn');
            $table->string('mother_name');
            $table->string('mother_name_bn');
            $table->string('home_district');
            $table->text('present_address');
            $table->text('present_address_bn');
            $table->text('permanent_address');
            $table->text('permanent_address_bn');
            $table->string('nid_number');
            $table->string('b_day');
            $table->string('b_month');
            $table->string('b_year');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('religion');
            $table->string('nationality')->default('Bangladeshi');
            $table->string('current_job_duration');
            $table->string('previous_job_duration');
            $table->string('total_job_duration');
            $table->string('mobile_no');
            $table->string('email');
            $table->string('photo')->nullable();
            $table->string('signature')->nullable();
            $table->string('writ_petition');
            $table->string('password');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
