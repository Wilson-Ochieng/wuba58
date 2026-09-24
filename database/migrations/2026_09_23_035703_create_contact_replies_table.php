<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contact_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_message_id')->constrained()->cascadeOnDelete();
            $table->enum('direction', ['outbound', 'inbound']); // outbound = you reply, inbound = user replies
            $table->text('body');
            $table->string('subject')->nullable();
            $table->boolean('read_by_admin')->default(true);   // outbound is read by default
            $table->boolean('read_by_user')->default(false);   // inbound users can't "read", only outbound
            $table->timestamp('emailed_at')->nullable();        // when it was sent
            $table->timestamps();

            $table->index(['contact_message_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_replies');
    }
};