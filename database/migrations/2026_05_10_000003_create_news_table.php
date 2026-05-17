<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('short_description', 300);
            $table->longText('content');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('author_id')->constrained('users')->cascadeOnDelete();
            $table->string('image')->nullable();
            $table->enum('video_type', ['none', 'local', 'youtube'])->default('none');
            $table->string('video_url')->nullable();
            $table->enum('language', ['en', 'ru', 'kz'])->default('en');
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->boolean('featured')->default(false);
            $table->unsignedInteger('views')->default(0);
            $table->string('tags')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'published_at']);
            $table->index(['featured', 'views']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
