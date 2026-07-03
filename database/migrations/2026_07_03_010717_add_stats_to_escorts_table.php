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
        Schema::table('escorts', function (Blueprint $table) {
            $table->unsignedInteger('views_count')->default(0)->after('profile_photo');
            $table->unsignedInteger('whatsapp_clicks_count')->default(0)->after('views_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('escorts', function (Blueprint $table) {
            $table->dropColumn(['views_count', 'whatsapp_clicks_count']);
        });
    }
};
