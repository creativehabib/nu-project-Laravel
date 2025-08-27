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
            $table->string('organization_name_en')->nullable();
            $table->unsignedInteger('organization_name_font_size')->nullable();
            $table->unsignedInteger('organization_logo_width')->nullable();
            $table->unsignedInteger('organization_logo_height')->nullable();
            $table->string('authority_signature')->nullable();
            $table->text('back_footer')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('id_card_settings', function (Blueprint $table) {
            $table->dropColumn([
                'organization_name_en',
                'organization_name_font_size',
                'organization_logo_width',
                'organization_logo_height',
                'authority_signature',
                'back_footer',
            ]);
        });
    }
};
