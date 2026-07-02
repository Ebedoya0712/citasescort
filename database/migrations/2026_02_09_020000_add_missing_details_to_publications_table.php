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
            $table->json('attends_in')->nullable(); // Hoteles, Lugar propio, etc.
            $table->json('attends_to')->nullable(); // Hombres, Mujeres, Parejas
            $table->text('schedule')->nullable();   // Horarios
            $table->json('services')->nullable();   // Servicios varios
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->dropColumn(['attends_in', 'attends_to', 'schedule', 'services']);
        });
    }
};
