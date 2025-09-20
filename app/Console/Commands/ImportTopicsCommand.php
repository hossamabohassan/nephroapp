<?php

namespace App\Console\Commands;

use App\Models\Topic;
use App\Models\Category;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ImportTopicsCommand extends Command
{
    protected $signature = 'topics:import {path : Path to the data folder containing JSON files}';
    protected $description = 'Import topics from JSON files in the specified directory';

    public function handle()
    {
        $dataPath = $this->argument('path');
        
        if (!is_dir($dataPath)) {
            $this->error("Directory not found: {$dataPath}");
            return 1;
        }

        $this->info("Starting import from: {$dataPath}");
        
        // First, let's read the manifest file to understand categories
        $manifestPath = $dataPath . '/manifest.json';
        if (file_exists($manifestPath)) {
            $this->importCategoriesFromManifest($manifestPath);
        }

        // Get all JSON files except manifest
        $jsonFiles = glob($dataPath . '/*.json');
        $jsonFiles = array_filter($jsonFiles, function($file) {
            return basename($file) !== 'manifest.json';
        });

        $this->info("Found " . count($jsonFiles) . " topic files to import");

        $bar = $this->output->createProgressBar(count($jsonFiles));
        $bar->start();

        $imported = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($jsonFiles as $file) {
            try {
                $result = $this->importTopicFromFile($file);
                if ($result === 'imported') {
                    $imported++;
                } elseif ($result === 'skipped') {
                    $skipped++;
                }
            } catch (\Exception $e) {
                $errors++;
                $this->error("\nError importing " . basename($file) . ": " . $e->getMessage());
            }
            $bar->advance();
        }

        $bar->finish();

        $this->newLine(2);
        $this->info("Import completed!");
        $this->table(['Status', 'Count'], [
            ['Imported', $imported],
            ['Skipped (already exists)', $skipped],
            ['Errors', $errors],
        ]);

        return 0;
    }

    private function importCategoriesFromManifest($manifestPath)
    {
        $this->info("Reading manifest file for categories...");
        
        $manifest = json_decode(file_get_contents($manifestPath), true);
        
        if (!isset($manifest['categories'])) {
            $this->warn("No categories found in manifest");
            return;
        }

        foreach ($manifest['categories'] as $categoryData) {
            $slug = Str::slug($categoryData['name']);
            
            Category::firstOrCreate(
                ['slug' => $slug],
                [
                    'name' => $categoryData['name'],
                    'description' => $categoryData['description'] ?? null
                ]
            );
            
            $this->line("Category: {$categoryData['name']} -> {$slug}");
        }
    }

    private function importTopicFromFile($filePath)
    {
        $fileName = basename($filePath, '.json');
        $data = json_decode(file_get_contents($filePath), true);

        if (!$data) {
            throw new \Exception("Invalid JSON in file: {$fileName}");
        }

        // Check if topic already exists
        $existingTopic = Topic::where('slug', $data['slug'] ?? $fileName)->first();
        if ($existingTopic) {
            return 'skipped';
        }

        // Find or create category
        $categoryId = $this->findCategoryId($data['slug'] ?? $fileName);
        
        // Get first admin user or create a system user
        $userId = User::where('role', 'admin')->first()?->id ?? User::first()?->id ?? 1;

        // Extract title from data
        $title = $data['TOPIC'] ?? $data['title'] ?? Str::title(str_replace('-', ' ', $fileName));
        
        // Create the topic
        $topic = Topic::create([
            'slug' => $data['slug'] ?? $fileName,
            'title' => $title,
            'subtitle' => $this->extractSubtitle($data),
            'summary' => $this->extractSummary($data),
            'status' => Topic::STATUS_PUBLISHED,
            'category_id' => $categoryId,
            'created_by' => $userId,
            'updated_by' => $userId,
            'data' => $data,
            'meta' => $this->extractMeta($data),
            'published_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return 'imported';
    }

    private function findCategoryId($slug)
    {
        // Try to find category from manifest mapping
        $manifestPath = $this->argument('path') . '/manifest.json';
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            
            if (isset($manifest['categories'])) {
                foreach ($manifest['categories'] as $categoryData) {
                    if (isset($categoryData['slugs']) && in_array($slug, $categoryData['slugs'])) {
                        $categorySlug = Str::slug($categoryData['name']);
                        $category = Category::where('slug', $categorySlug)->first();
                        if ($category) {
                            return $category->id;
                        }
                    }
                }
            }
        }

        // Default to uncategorized
        $uncategorized = Category::firstOrCreate(
            ['slug' => 'uncategorized'],
            ['name' => 'Uncategorized']
        );

        return $uncategorized->id;
    }

    private function extractSubtitle($data)
    {
        // Try to extract a subtitle from various fields
        if (isset($data['CHIP_1']) && isset($data['CHIP_2']) && isset($data['CHIP_3'])) {
            return implode(' • ', [$data['CHIP_1'], $data['CHIP_2'], $data['CHIP_3']]);
        }
        
        if (isset($data['subtitle'])) {
            return $data['subtitle'];
        }

        return null;
    }

    private function extractSummary($data)
    {
        // Try to extract summary from various fields
        if (isset($data['OPENING_PARAGRAPH_HTML_SAFE'])) {
            return strip_tags($data['OPENING_PARAGRAPH_HTML_SAFE']);
        }
        
        if (isset($data['summary'])) {
            return $data['summary'];
        }

        // Extract from immediate priorities if available
        if (isset($data['IMMEDIATE_PRIORITIES_LI']) && is_array($data['IMMEDIATE_PRIORITIES_LI'])) {
            $summary = "Key priorities: " . implode('. ', array_slice(array_map(function($item) {
                return strip_tags($item);
            }, $data['IMMEDIATE_PRIORITIES_LI']), 0, 2));
            
            return Str::limit($summary, 250);
        }

        return null;
    }

    private function extractMeta($data)
    {
        $meta = [];
        
        // Extract chips/tags
        if (isset($data['CHIP_1'], $data['CHIP_2'], $data['CHIP_3'])) {
            $meta['chips'] = [
                $data['CHIP_1'],
                $data['CHIP_2'],
                $data['CHIP_3']
            ];
        }

        // Add any template information
        if (isset($data['template'])) {
            $meta['template'] = $data['template'];
        }

        // Count various sections for metadata
        $sectionCounts = [];
        $countableFields = ['IMMEDIATE_PRIORITIES_LI', 'INVESTIGATIONS_LI', 'VIVA_ITEMS', 'PITFALLS_LI'];
        
        foreach ($countableFields as $field) {
            if (isset($data[$field]) && is_array($data[$field])) {
                $sectionCounts[strtolower(str_replace('_LI', '', $field))] = count($data[$field]);
            }
        }
        
        if (!empty($sectionCounts)) {
            $meta['section_counts'] = $sectionCounts;
        }

        return !empty($meta) ? $meta : null;
    }
}
