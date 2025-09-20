<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('auth_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('allow_email_registration')->default(true);
            $table->boolean('allow_google_auth')->default(false);
            $table->timestamps();
        });

        DB::table('auth_settings')->insert([
            'allow_email_registration' => true,
            'allow_google_auth' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auth_settings');
    }
};
