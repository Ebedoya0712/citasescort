<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('escorts', function (Blueprint $table) {
            $table->string('waist')->nullable();
            $table->string('hips')->nullable();
            $table->string('bust')->nullable();
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->string('waist')->nullable();
            $table->string('hips')->nullable();
            $table->string('bust')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('escorts', function (Blueprint $table) {
            $table->dropColumn(['waist', 'hips', 'bust']);
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->dropColumn(['waist', 'hips', 'bust']);
        });
    }
};
