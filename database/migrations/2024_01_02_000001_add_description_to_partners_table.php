<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->string('description_uz')->nullable()->after('name_en');
            $table->string('description_ru')->nullable()->after('description_uz');
            $table->string('description_en')->nullable()->after('description_ru');
        });
    }

    public function down(): void
    {
        Schema::table('partners', function (Blueprint $table) {
            $table->dropColumn(['description_uz', 'description_ru', 'description_en']);
        });
    }
};
