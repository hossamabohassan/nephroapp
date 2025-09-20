<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NavigationSection;

class NavigationSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        NavigationSection::truncate();
        
        // Get default sections from the model
        $defaultSections = NavigationSection::getDefaultSections();
        
        // Insert all default sections
        foreach ($defaultSections as $section) {
            NavigationSection::create($section);
        }
    }
}
