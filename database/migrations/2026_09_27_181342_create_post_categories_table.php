<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color')->default('#ECB143');
            $table->text('description')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('published')->default(true);
            $table->timestamps();
        });

        // Add category_id to posts, drop the old string column
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('post_category_id')
                ->nullable()
                ->after('id')
                ->constrained('post_categories')
                ->nullOnDelete();

            // Drop the old string column
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['post_category_id']);
            $table->dropColumn('post_category_id');
            $table->string('category')->default('news');
        });

        Schema::dropIfExists('post_categories');
    }
};