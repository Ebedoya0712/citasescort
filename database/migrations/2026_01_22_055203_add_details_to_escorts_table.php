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
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->integer('height')->nullable(); // in cm
            $table->string('hair_color')->nullable();
            $table->decimal('cost_30m', 10, 2)->nullable();
            $table->json('services')->nullable();
            $table->json('attends_to')->nullable(); // Men, Women, Couples
            $table->json('attends_in')->nullable(); // Apartment, Hotel, etc.
            $table->json('photos')->nullable()->change(); // Ensure this is json/array if not already
            $table->string('video')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('escorts', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 
                'whatsapp', 
                'height', 
                'hair_color', 
                'cost_30m', 
                'services', 
                'attends_to', 
                'attends_in', 
                'video'
            ]);
        });
    }
};
