<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('path', 500);
            $table->string('route_name')->nullable();
            $table->string('referrer', 500)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('device_type', 20)->nullable(); // desktop | tablet | mobile
            $table->string('country', 60)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('ip_hash', 64)->nullable();     // hashed for privacy
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index('created_at');
            $table->index('path');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};