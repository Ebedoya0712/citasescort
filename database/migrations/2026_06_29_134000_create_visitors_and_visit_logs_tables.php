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
        Schema::create('visitors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->timestamp('first_visit_at')->useCurrent();
            $table->timestamp('last_visit_at')->useCurrent();
            $table->integer('total_visits')->default(1);
            $table->integer('whatsapp_clicks')->default(0);
            
            // UTM y Orígenes de campaña
            $table->string('utm_source')->nullable();
            $table->string('utm_medium')->nullable();
            $table->string('utm_campaign')->nullable();
            $table->string('utm_content')->nullable();
            $table->string('utm_term')->nullable();
            $table->string('gclid')->nullable();
            $table->string('fbclid')->nullable();
            
            // Geolocalización y Navegador
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->string('browser')->nullable();
            $table->string('device')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            
            $table->timestamps();
        });

        Schema::create('visit_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('visitor_id');
            $table->text('url');
            $table->text('referrer')->nullable();
            $table->integer('duration')->default(0); // duración en segundos
            $table->timestamps();

            $table->foreign('visitor_id')->references('id')->on('visitors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_logs');
        Schema::dropIfExists('visitors');
    }
};
