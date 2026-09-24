<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tour_hotspots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_scene_id')->constrained()->cascadeOnDelete();
            $table->foreignId('target_scene_id')->nullable()->constrained('tour_scenes')->nullOnDelete();
            $table->float('yaw');
            $table->float('pitch');
            $table->string('label')->nullable();
            $table->string('type')->default('scene');
            $table->string('url')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_hotspots');
    }
};