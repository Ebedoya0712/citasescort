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
            $table->string('gender')->default('female')->after('age'); // female, male, trans
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('escorts', function (Blueprint $table) {
            $table->dropColumn('gender');
        });
    }
};
