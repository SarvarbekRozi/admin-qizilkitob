<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('blog_categories')->nullOnDelete();
            $table->string('slug')->unique();
            $table->string('title_uz');
            $table->string('title_ru');
            $table->string('title_en');
            $table->text('excerpt_uz')->nullable();
            $table->text('excerpt_ru')->nullable();
            $table->text('excerpt_en')->nullable();
            $table->longText('content_uz')->nullable();
            $table->longText('content_ru')->nullable();
            $table->longText('content_en')->nullable();
            $table->string('image')->nullable();
            $table->string('author')->nullable();
            $table->string('video')->nullable();
            $table->string('audio')->nullable();
            $table->integer('views_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('publish_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
