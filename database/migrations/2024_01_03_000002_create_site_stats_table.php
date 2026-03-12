<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_stats', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // animals, plants, zones, researchers
            $table->string('value'); // "120", "350", "5", "1000"
            $table->string('suffix')->default('+'); // "+", "", "ta"
            $table->string('label_uz');
            $table->string('label_ru');
            $table->string('label_en');
            $table->string('icon')->default('fas fa-chart-bar');
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_stats');
    }
};
