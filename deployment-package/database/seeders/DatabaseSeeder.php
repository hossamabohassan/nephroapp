<?php

namespace Database\Seeders;

use App\Models\Template;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $defaultCategory = Category::firstOrCreate(
            ['slug' => 'uncategorized'],
            ['name' => 'Uncategorized']
        );

        Category::firstOrCreate(
            ['slug' => 'renal-transplant'],
            ['name' => 'Renal Transplant']
        );

        Template::firstOrCreate(
            ['slug' => 'viva-default'],
            [
                'name' => 'Viva Default',
                'view' => 'topics.templates.viva',
                'description' => 'Default renderer for viva cases imported from ChatGPT JSON.',
                'is_default' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'role' => User::ROLE_ADMIN,
                'is_active' => true,
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
            ]
        );
    }
}
