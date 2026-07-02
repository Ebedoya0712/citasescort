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
            if (!Schema::hasColumn('publications', 'gender')) $table->string('gender')->nullable();
            if (!Schema::hasColumn('publications', 'age')) $table->integer('age')->nullable();
            if (!Schema::hasColumn('publications', 'height')) $table->string('height')->nullable();
            if (!Schema::hasColumn('publications', 'hair_color')) $table->string('hair_color')->nullable();
            if (!Schema::hasColumn('publications', 'price')) $table->decimal('price', 10, 2)->nullable();
            if (!Schema::hasColumn('publications', 'oral_sex')) $table->string('oral_sex')->nullable();
            if (!Schema::hasColumn('publications', 'fantasies')) $table->json('fantasies')->nullable();
            if (!Schema::hasColumn('publications', 'virtual_services')) $table->json('virtual_services')->nullable();
            if (!Schema::hasColumn('publications', 'phone')) $table->string('phone')->nullable();
            if (!Schema::hasColumn('publications', 'whatsapp')) $table->string('whatsapp')->nullable();
            if (!Schema::hasColumn('publications', 'instagram')) $table->string('instagram')->nullable();
            if (!Schema::hasColumn('publications', 'twitter')) $table->string('twitter')->nullable();
            if (!Schema::hasColumn('publications', 'onlyfans')) $table->string('onlyfans')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->dropColumn([
                'gender', 'age', 'height', 'hair_color', 'price', 
                'oral_sex', 'fantasies', 'virtual_services',
                'phone', 'whatsapp', 'instagram', 'twitter', 'onlyfans'
            ]);
        });
    }
};
