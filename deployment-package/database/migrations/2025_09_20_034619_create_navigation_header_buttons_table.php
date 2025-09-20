<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('navigation_header_buttons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('icon')->nullable();
            $table->string('url')->nullable();
            $table->string('route_name')->nullable();
            $table->string('type')->default('button'); // button, dropdown, modal
            $table->json('dropdown_items')->nullable(); // For dropdown buttons
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('target')->default('_self'); // _self, _blank, modal
            $table->string('css_class')->nullable();
            $table->string('badge_text')->nullable(); // For notification badges
            $table->string('badge_color')->default('red'); // Badge color
            $table->boolean('show_badge')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigation_header_buttons');
    }
};