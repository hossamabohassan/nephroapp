<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_completed', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('topic_id')->constrained()->onDelete('cascade');
            $table->timestamp('completed_at');
            $table->text('notes')->nullable(); // Optional notes about completion
            $table->timestamps();

            // Ensure a user can only mark a topic as completed once
            $table->unique(['user_id', 'topic_id']);
            
            // Add indexes for performance
            $table->index(['user_id', 'completed_at']);
            $table->index(['topic_id', 'completed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_completed');
    }
};