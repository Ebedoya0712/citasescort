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
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('escort_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('photos')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('city')->nullable();
            $table->string('oral_sex')->nullable();
            $table->json('fantasies')->nullable();
            $table->json('virtual_services')->nullable();
            
            // Personal Details
            $table->integer('age')->nullable();
            $table->string('gender')->nullable(); // Mujer, Hombre, Trans, etc.
            $table->string('height')->nullable();
            $table->string('hair_color')->nullable();
            
            // Contact & Socials
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('onlyfans')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
