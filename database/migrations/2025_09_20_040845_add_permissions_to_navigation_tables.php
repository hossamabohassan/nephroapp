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
        // Add permissions to navigation_menu_items table
        Schema::table('navigation_menu_items', function (Blueprint $table) {
            $table->string('permission')->default('public')->after('css_class');
        });

        // Add permissions to navigation_header_buttons table
        Schema::table('navigation_header_buttons', function (Blueprint $table) {
            $table->string('permission')->default('public')->after('css_class');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('navigation_menu_items', function (Blueprint $table) {
            $table->dropColumn('permission');
        });

        Schema::table('navigation_header_buttons', function (Blueprint $table) {
            $table->dropColumn('permission');
        });
    }
};