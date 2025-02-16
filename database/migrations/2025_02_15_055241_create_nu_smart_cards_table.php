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
        Schema::create('nu_smart_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->string('pf_number')->nullable()->unique();
            $table->date('birth_date')->nullable();
            $table->string('prl_date')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('blood_group')->nullable();
            $table->text('present_address')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('signature')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nu_smart_cards');
    }
};
