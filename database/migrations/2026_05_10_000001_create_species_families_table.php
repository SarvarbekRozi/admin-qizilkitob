<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('species_families', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['animal', 'plant']);
            $table->string('slug')->unique();
            $table->string('name_uz');
            $table->string('name_ru');
            $table->string('name_en');
            $table->string('latin_name')->nullable();
            $table->integer('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('species_families');
    }
};
