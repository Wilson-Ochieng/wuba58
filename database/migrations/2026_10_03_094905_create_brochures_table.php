<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brochures', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('category')->nullable();     // e.g. "Residential", "Masterplan"
            $table->boolean('published')->default(true);
            $table->integer('order')->default(0);
            $table->integer('download_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('brochure_leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brochure_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->text('message')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('emailed_at')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->index(['brochure_id', 'created_at']);
            $table->index('is_read');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brochure_leads');
        Schema::dropIfExists('brochures');
    }
};