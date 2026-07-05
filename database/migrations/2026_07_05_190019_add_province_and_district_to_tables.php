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
        Schema::table('publications', function (Blueprint $table) {
            $table->string('province')->nullable()->after('city');
            $table->string('district')->nullable()->after('province');
        });

        Schema::table('escorts', function (Blueprint $table) {
            $table->string('province')->nullable()->after('city');
            $table->string('district')->nullable()->after('province');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->dropColumn(['province', 'district']);
        });

        Schema::table('escorts', function (Blueprint $table) {
            $table->dropColumn(['province', 'district']);
        });
    }
};
