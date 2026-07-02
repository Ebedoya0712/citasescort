<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('escorts', function (Blueprint $table) {
            $table->string('telegram')->nullable();
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->string('telegram')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('escorts', function (Blueprint $table) {
            $table->dropColumn('telegram');
        });

        Schema::table('publications', function (Blueprint $table) {
            $table->dropColumn('telegram');
        });
    }
};
