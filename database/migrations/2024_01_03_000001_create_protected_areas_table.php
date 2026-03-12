<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('protected_areas', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name_uz');
            $table->string('name_ru');
            $table->string('name_en');
            $table->string('count_text')->nullable(); // "7 ta", "12 ta"
            $table->string('icon')->default('fas fa-mountain'); // Font Awesome class
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('protected_areas');
    }
};
