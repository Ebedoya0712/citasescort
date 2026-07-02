<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Ampliar el ENUM para que acepte tanto los viejos como los nuevos
        DB::statement("ALTER TABLE escorts MODIFY COLUMN level ENUM('general', 'standard', 'silver', 'diamond', 'plata', 'diamante') DEFAULT 'general'");
        
        // 2. Mapear los valores viejos a los nuevos
        DB::table('escorts')->where('level', 'standard')->update(['level' => 'general']);
        DB::table('escorts')->where('level', 'silver')->update(['level' => 'plata']);
        DB::table('escorts')->where('level', 'diamond')->update(['level' => 'diamante']);
        
        // 3. (Opcional) Limpiar el ENUM para dejar solo los 3 nuevos
        DB::statement("ALTER TABLE escorts MODIFY COLUMN level ENUM('general', 'plata', 'diamante') DEFAULT 'general'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('escorts')->where('level', 'plata')->update(['level' => 'silver']);
        DB::table('escorts')->where('level', 'diamante')->update(['level' => 'diamond']);
        
        DB::statement("ALTER TABLE escorts MODIFY COLUMN level ENUM('general', 'silver', 'diamond') DEFAULT 'general'");
    }
};
