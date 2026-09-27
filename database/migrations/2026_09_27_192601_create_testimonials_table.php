<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('author_name');
            $table->string('author_role')->nullable();       // "Director, Vantage Properties"
            $table->string('author_company')->nullable();
            $table->string('author_avatar_url')->nullable(); // Google avatar URL
            $table->text('body');
            $table->tinyInteger('rating')->default(5);       // 1-5 stars
            $table->string('source')->default('manual');     // manual | google
            $table->string('source_url')->nullable();        // Google review permalink
            $table->string('external_id')->nullable()->unique(); // Google review ID to prevent duplicates
            $table->timestamp('reviewed_at')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('published')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['published', 'featured']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};