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
            $table->string('id_front')->nullable();
            $table->string('id_back')->nullable();
            $table->string('verification_video')->nullable();
            $table->string('verification_status')->default('unverified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('escorts', function (Blueprint $table) {
            $table->dropColumn('id_front');
            $table->dropColumn('id_back');
            $table->dropColumn('verification_video');
            $table->dropColumn('verification_status');
        });
    }
};
