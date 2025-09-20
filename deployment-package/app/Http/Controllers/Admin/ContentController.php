<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use App\Helpers\ContentHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'active']);
        $this->middleware('can:manage-content');
    }

    public function index(): View
    {
        $contentSections = PageContent::all()->keyBy('key');
        
        // Define all available content sections with default values
        $defaultSections = [
            'site_name' => [
                'key' => 'site_name',
                'title' => 'Site Name',
                'description' => 'The main name/brand of your website',
                'type' => 'text',
                'value' => 'NephroCoach',
                'group' => 'general'
            ],
            'site_tagline' => [
                'key' => 'site_tagline',
                'title' => 'Site Tagline',
                'description' => 'Short description or slogan for your site',
                'type' => 'text', 
                'value' => 'Expert Medical Training Platform',
                'group' => 'general'
            ],
            'hero_title' => [
                'key' => 'hero_title',
                'title' => 'Hero Section Title',
                'description' => 'Main headline on the homepage',
                'type' => 'text',
                'value' => 'Master Clinical Nephrology with Expert-Crafted Scenarios',
                'group' => 'homepage'
            ],
            'hero_subtitle' => [
                'key' => 'hero_subtitle',
                'title' => 'Hero Section Subtitle',
                'description' => 'Supporting text under the main headline',
                'type' => 'textarea',
                'value' => 'Dive deep into real-world nephrology cases with interactive scenarios designed by leading experts. Perfect your clinical reasoning and diagnostic skills.',
                'group' => 'homepage'
            ],
            'hero_cta_primary' => [
                'key' => 'hero_cta_primary',
                'title' => 'Primary CTA Button Text',
                'description' => 'Text for the main call-to-action button',
                'type' => 'text',
                'value' => 'Get Started',
                'group' => 'homepage'
            ],
            'hero_cta_secondary' => [
                'key' => 'hero_cta_secondary',
                'title' => 'Secondary CTA Button Text',
                'description' => 'Text for the secondary call-to-action button',
                'type' => 'text',
                'value' => 'View Topics',
                'group' => 'homepage'
            ],
            'footer_text' => [
                'key' => 'footer_text',
                'title' => 'Footer Copyright Text',
                'description' => 'Copyright notice in the footer',
                'type' => 'text',
                'value' => '© 2024 NephroCoach. All rights reserved.',
                'group' => 'general'
            ],
            'contact_email' => [
                'key' => 'contact_email',
                'title' => 'Contact Email',
                'description' => 'Main contact email address',
                'type' => 'email',
                'value' => 'info@nephrocoach.com',
                'group' => 'contact'
            ],
            'about_text' => [
                'key' => 'about_text',
                'title' => 'About Section Text',
                'description' => 'Description of your platform/service',
                'type' => 'textarea',
                'value' => 'NephroCoach provides comprehensive medical training scenarios for nephrology professionals. Our expert-crafted content helps you master complex clinical situations.',
                'group' => 'general'
            ],
            // Topics Page Content
            'topics_search_placeholder' => [
                'key' => 'topics_search_placeholder',
                'title' => 'Topics Search Placeholder',
                'description' => 'Placeholder text for the main search bar on topics page',
                'type' => 'text',
                'value' => 'Search topics, categories...',
                'group' => 'topics'
            ],
            'topics_search_filter_placeholder' => [
                'key' => 'topics_search_filter_placeholder',
                'title' => 'Topics Filter Search Placeholder',
                'description' => 'Placeholder text for the filter search input',
                'type' => 'text',
                'value' => 'Search by title, content...',
                'group' => 'topics'
            ],
            'topics_total_label' => [
                'key' => 'topics_total_label',
                'title' => 'Total Topics Label',
                'description' => 'Label for the total topics statistic',
                'type' => 'text',
                'value' => 'Total Topics',
                'group' => 'topics'
            ],
            'topics_categories_label' => [
                'key' => 'topics_categories_label',
                'title' => 'Categories Label',
                'description' => 'Label for the categories statistic',
                'type' => 'text',
                'value' => 'Categories',
                'group' => 'topics'
            ],
            'topics_success_rate_label' => [
                'key' => 'topics_success_rate_label',
                'title' => 'Success Rate Label',
                'description' => 'Label for the success rate statistic',
                'type' => 'text',
                'value' => 'Success Rate',
                'group' => 'topics'
            ],
            'topics_support_label' => [
                'key' => 'topics_support_label',
                'title' => 'Support Label',
                'description' => 'Label for the support statistic',
                'type' => 'text',
                'value' => 'Support',
                'group' => 'topics'
            ],
            'topics_library_title' => [
                'key' => 'topics_library_title',
                'title' => 'Topic Library Title',
                'description' => 'Main title for the topics library section',
                'type' => 'text',
                'value' => 'Topic Library',
                'group' => 'topics'
            ],
            'topics_library_description' => [
                'key' => 'topics_library_description',
                'title' => 'Topic Library Description',
                'description' => 'Description text for the topics library section',
                'type' => 'textarea',
                'value' => 'Explore and filter through our comprehensive collection of nephrology topics',
                'group' => 'topics'
            ],
            'topics_search_label' => [
                'key' => 'topics_search_label',
                'title' => 'Search Topics Label',
                'description' => 'Label for the search topics filter',
                'type' => 'text',
                'value' => 'Search Topics',
                'group' => 'topics'
            ],
            'topics_category_label' => [
                'key' => 'topics_category_label',
                'title' => 'Category Filter Label',
                'description' => 'Label for the category filter',
                'type' => 'text',
                'value' => 'Category',
                'group' => 'topics'
            ],
            'topics_all_categories_option' => [
                'key' => 'topics_all_categories_option',
                'title' => 'All Categories Option',
                'description' => 'Text for the "All Categories" filter option',
                'type' => 'text',
                'value' => 'All Categories',
                'group' => 'topics'
            ],
            'topics_date_range_label' => [
                'key' => 'topics_date_range_label',
                'title' => 'Date Range Filter Label',
                'description' => 'Label for the date range filter',
                'type' => 'text',
                'value' => 'Date Range',
                'group' => 'topics'
            ],
            'topics_all_time_option' => [
                'key' => 'topics_all_time_option',
                'title' => 'All Time Option',
                'description' => 'Text for the "All Time" filter option',
                'type' => 'text',
                'value' => 'All Time',
                'group' => 'topics'
            ],
            'topics_today_option' => [
                'key' => 'topics_today_option',
                'title' => 'Today Option',
                'description' => 'Text for the "Today" filter option',
                'type' => 'text',
                'value' => 'Today',
                'group' => 'topics'
            ],
            'topics_this_week_option' => [
                'key' => 'topics_this_week_option',
                'title' => 'This Week Option',
                'description' => 'Text for the "This Week" filter option',
                'type' => 'text',
                'value' => 'This Week',
                'group' => 'topics'
            ],
            'topics_this_month_option' => [
                'key' => 'topics_this_month_option',
                'title' => 'This Month Option',
                'description' => 'Text for the "This Month" filter option',
                'type' => 'text',
                'value' => 'This Month',
                'group' => 'topics'
            ],
            'topics_this_year_option' => [
                'key' => 'topics_this_year_option',
                'title' => 'This Year Option',
                'description' => 'Text for the "This Year" filter option',
                'type' => 'text',
                'value' => 'This Year',
                'group' => 'topics'
            ],
            'topics_sort_by_label' => [
                'key' => 'topics_sort_by_label',
                'title' => 'Sort By Label',
                'description' => 'Label for the sort by filter',
                'type' => 'text',
                'value' => 'Sort By',
                'group' => 'topics'
            ],
            'topics_newest_first_option' => [
                'key' => 'topics_newest_first_option',
                'title' => 'Newest First Option',
                'description' => 'Text for the "Newest First" sort option',
                'type' => 'text',
                'value' => 'Newest First',
                'group' => 'topics'
            ],
            'topics_oldest_first_option' => [
                'key' => 'topics_oldest_first_option',
                'title' => 'Oldest First Option',
                'description' => 'Text for the "Oldest First" sort option',
                'type' => 'text',
                'value' => 'Oldest First',
                'group' => 'topics'
            ],
            'topics_alphabetical_option' => [
                'key' => 'topics_alphabetical_option',
                'title' => 'Alphabetical Option',
                'description' => 'Text for the "Alphabetical" sort option',
                'type' => 'text',
                'value' => 'Alphabetical',
                'group' => 'topics'
            ],
            'topics_most_popular_option' => [
                'key' => 'topics_most_popular_option',
                'title' => 'Most Popular Option',
                'description' => 'Text for the "Most Popular" sort option',
                'type' => 'text',
                'value' => 'Most Popular',
                'group' => 'topics'
            ],
            'topics_no_results_title' => [
                'key' => 'topics_no_results_title',
                'title' => 'No Topics Found Title',
                'description' => 'Title shown when no topics are found',
                'type' => 'text',
                'value' => 'No topics found',
                'group' => 'topics'
            ],
            'topics_no_results_description' => [
                'key' => 'topics_no_results_description',
                'title' => 'No Topics Found Description',
                'description' => 'Description shown when no topics are found',
                'type' => 'text',
                'value' => 'Get started by creating your first topic.',
                'group' => 'topics'
            ],
            // Welcome Page Content
            'welcome_title' => [
                'key' => 'welcome_title',
                'title' => 'Welcome Page Title',
                'description' => 'Main title on the welcome page',
                'type' => 'text',
                'value' => 'Let\'s get started',
                'group' => 'welcome'
            ],
            'welcome_description' => [
                'key' => 'welcome_description',
                'title' => 'Welcome Page Description',
                'description' => 'Description text on the welcome page',
                'type' => 'textarea',
                'value' => 'Laravel has an incredibly rich ecosystem. We suggest starting with the following.',
                'group' => 'welcome'
            ],
            'welcome_documentation_link' => [
                'key' => 'welcome_documentation_link',
                'title' => 'Documentation Link Text',
                'description' => 'Text for the documentation link',
                'type' => 'text',
                'value' => 'Documentation',
                'group' => 'welcome'
            ],
            'welcome_laracasts_link' => [
                'key' => 'welcome_laracasts_link',
                'title' => 'Laracasts Link Text',
                'description' => 'Text for the Laracasts link',
                'type' => 'text',
                'value' => 'Laracasts',
                'group' => 'welcome'
            ],
            'welcome_deploy_button' => [
                'key' => 'welcome_deploy_button',
                'title' => 'Deploy Button Text',
                'description' => 'Text for the deploy button',
                'type' => 'text',
                'value' => 'Deploy now',
                'group' => 'welcome'
            ]
        ];

        // Merge with existing content, prioritizing database values
        $allSections = collect($defaultSections)->map(function ($default, $key) use ($contentSections) {
            if (isset($contentSections[$key])) {
                return array_merge($default, [
                    'value' => $contentSections[$key]->value,
                    'updated_at' => $contentSections[$key]->updated_at,
                ]);
            }
            return $default;
        });

        // Group sections
        $groupedSections = $allSections->groupBy('group');

        return view('admin.content.index', [
            'groupedSections' => $groupedSections,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'required|array',
            'content.*' => 'nullable|string|max:5000',
        ]);

        foreach ($validated['content'] as $key => $value) {
            PageContent::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Clear content cache so changes appear immediately
        ContentHelper::clearCache();

        return redirect()
            ->route('admin.content.index')
            ->with('success', 'Content updated successfully. Changes are now live on your website.');
    }
}
