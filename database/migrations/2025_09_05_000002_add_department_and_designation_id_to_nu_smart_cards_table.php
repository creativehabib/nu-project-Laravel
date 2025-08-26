<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nu_smart_cards', function (Blueprint $table) {
            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();
            $table->foreignId('designation_id')
                ->nullable()
                ->constrained('designations')
                ->nullOnDelete();
            $table->dropColumn(['department', 'designation']);
        });
    }

    public function down(): void
    {
        Schema::table('nu_smart_cards', function (Blueprint $table) {
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->dropConstrainedForeignId('department_id');
            $table->dropConstrainedForeignId('designation_id');
        });
    }
};
