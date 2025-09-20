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
        Schema::create('navigation_menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('url')->nullable();
            $table->string('route_name')->nullable();
            $table->string('type')->default('link'); // link, dropdown, separator
            $table->json('dropdown_items')->nullable(); // For dropdown menus
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('target')->default('_self'); // _self, _blank
            $table->string('css_class')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigation_menu_items');
    }
};