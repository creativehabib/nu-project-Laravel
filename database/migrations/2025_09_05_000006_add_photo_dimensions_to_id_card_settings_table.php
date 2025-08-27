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
        Schema::table('id_card_settings', function (Blueprint $table) {
            $table->decimal('photo_width', 5, 2)->nullable();
            $table->decimal('photo_height', 5, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('id_card_settings', function (Blueprint $table) {
            $table->dropColumn(['photo_width', 'photo_height']);
        });
    }
};
