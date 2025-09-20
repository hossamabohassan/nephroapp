<?php

namespace App\Services;

use App\Models\Template;
use App\Models\Topic;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\View;

class TopicRenderer
{
    protected $navigationSections = [];

    public function render(Topic $topic, ?Template $template = null): string
    {
        $template ??= $topic->template ?? $this->defaultTemplate();
        $view = $template?->view ?? 'topics.templates.viva';

        if ($view === 'topics.templates.viva') {
            return $this->renderLegacyTemplate($topic);
        }

        return View::make($view, [
            'topic' => $topic,
            'payload' => $this->preparePayload($topic->data ?? []),
            'template' => $template,
        ])->render();
    }

    public function getNavigationSections(): array
    {
        return $this->navigationSections;
    }

    protected function preparePayload(array $data): array
    {
        $chips = array_values(array_filter([
            Arr::get($data, 'CHIP_1'),
            Arr::get($data, 'CHIP_2'),
            Arr::get($data, 'CHIP_3'),
        ], fn ($value) => filled($value)));

        return [
            'title' => Arr::get($data, 'TOPIC'),
            'subtitle' => Arr::get($data, 'SUBTITLE'),
            'chips' => $chips,
            'summary' => Arr::get($data, 'OPENING_PARAGRAPH_HTML_SAFE'),
            'sections' => $data,
        ];
    }

    protected function renderLegacyTemplate(Topic $topic): string
    {
        $templatePath = resource_path('views/topics/templates/vivatemplate.html');
        $html = file_get_contents($templatePath) ?: '';
        $data = $topic->data ?? [];
        
        // Extract navigation sections for sidebar
        $this->extractNavigationSections($html, $topic);

        $replace = [
            'TOPIC' => $data['TOPIC'] ?? $topic->title ?? 'Untitled',
            'CHIP_1' => $data['CHIP_1'] ?? 'Setting',
            'CHIP_2' => $data['CHIP_2'] ?? 'Audience',
            'CHIP_3' => $data['CHIP_3'] ?? 'Trigger',
            'OPENING_PARAGRAPH_HTML_SAFE' => $data['OPENING_PARAGRAPH_HTML_SAFE'] ?? '',
            'IMMEDIATE_PRIORITIES_LI' => $this->renderList($data['IMMEDIATE_PRIORITIES_LI'] ?? []),
            'DDX_BUCKET_1_TITLE' => $data['DDX_BUCKET_1_TITLE'] ?? 'Bucket 1',
            'DDX_BUCKET_1_ITEMS_LI' => $this->renderList($data['DDX_BUCKET_1_ITEMS_LI'] ?? []),
            'DDX_BUCKET_2_TITLE' => $data['DDX_BUCKET_2_TITLE'] ?? 'Bucket 2',
            'DDX_BUCKET_2_ITEMS_LI' => $this->renderList($data['DDX_BUCKET_2_ITEMS_LI'] ?? []),
            'DDX_BUCKET_3_TITLE' => $data['DDX_BUCKET_3_TITLE'] ?? 'Bucket 3',
            'DDX_BUCKET_3_ITEMS_LI' => $this->renderList($data['DDX_BUCKET_3_ITEMS_LI'] ?? []),
            'DIFFERENTIAL_FOCUS_HTML' => $data['DIFFERENTIAL_FOCUS_HTML'] ?? '',
            'QUICK_REF_CARD_HTML' => $data['QUICK_REF_CARD_HTML'] ?? '',
            'INVESTIGATIONS_LI' => $this->renderList($data['INVESTIGATIONS_LI'] ?? []),
            'EMERGENCY_ALGORITHM_HTML' => $data['EMERGENCY_ALGORITHM_HTML'] ?? '',
            'PILLAR_1' => $data['PILLAR_1'] ?? 'Pillar 1',
            'STEP_1_TITLE' => $data['STEP_1_TITLE'] ?? 'Step 1',
            'STEP_1_LI' => $this->renderList($data['STEP_1_LI'] ?? []),
            'STEP_2_TITLE' => $data['STEP_2_TITLE'] ?? 'Step 2',
            'STEP_2_LI' => $this->renderList($data['STEP_2_LI'] ?? []),
            'PILLAR_2' => $data['PILLAR_2'] ?? 'Pillar 2',
            'STEP_3_TITLE' => $data['STEP_3_TITLE'] ?? 'Step 3',
            'STEP_3_LI' => $this->renderList($data['STEP_3_LI'] ?? []),
            'STEP_4_TITLE' => $data['STEP_4_TITLE'] ?? 'Step 4',
            'STEP_4_LI' => $this->renderList($data['STEP_4_LI'] ?? []),
            'PHARMACOLOGY_TABLE_HTML' => $data['PHARMACOLOGY_TABLE_HTML'] ?? '',
            'TOPIC_BLOCK_A_TITLE' => $data['TOPIC_BLOCK_A_TITLE'] ?? 'Block A',
            'TOPIC_BLOCK_A_ITEMS_LI' => $this->renderList($data['TOPIC_BLOCK_A_ITEMS_LI'] ?? []),
            'TOPIC_BLOCK_B_TITLE' => $data['TOPIC_BLOCK_B_TITLE'] ?? 'Block B',
            'TOPIC_BLOCK_B_ITEMS_LI' => $this->renderList($data['TOPIC_BLOCK_B_ITEMS_LI'] ?? []),
            'TOPIC_BLOCK_C_TITLE' => $data['TOPIC_BLOCK_C_TITLE'] ?? 'Block C',
            'TOPIC_BLOCK_C_ITEMS_LI' => $this->renderList($data['TOPIC_BLOCK_C_ITEMS_LI'] ?? []),
            'QUALITY_PROCESS_LI' => $this->renderList($data['QUALITY_PROCESS_LI'] ?? []),
            'QUALITY_OUTCOME_LI' => $this->renderList($data['QUALITY_OUTCOME_LI'] ?? []),
            'QUALITY_SAFETY_LI' => $this->renderList($data['QUALITY_SAFETY_LI'] ?? []),
            'SAFETY_LIST_HTML' => $this->renderList($data['SAFETY_LI'] ?? []),
            'COMMUNICATION_LIST_HTML' => $this->renderList($data['COMMUNICATION_LI'] ?? []),
            'CASE_SCENARIOS_HTML' => $this->renderAccordion($data['CASE_SCENARIOS_HTML'] ?? [], 'cases'),
            'VIVA_ITEMS' => $this->renderAccordion($data['VIVA_ITEMS'] ?? [], 'viva'),
            'PITFALLS_LI' => $this->renderList($data['PITFALLS_LI'] ?? []),
            'ANSWER_STEPS_OL' => $this->renderList($data['ANSWER_STEPS_OL'] ?? []),
            'TEACHING_CONCEPTS_LI' => $this->renderList($data['TEACHING_CONCEPTS_LI'] ?? []),
            'TEACHING_MISTAKES_LI' => $this->renderList($data['TEACHING_MISTAKES_LI'] ?? []),
            'CONCEPT_DIAGRAM_HTML' => $data['CONCEPT_DIAGRAM_HTML'] ?? '',
            'ASCII_FLOWCHART_PRE' => $data['ASCII_FLOWCHART_PRE'] ?? '',
            'EVIDENCE_STUDIES_LI' => $this->renderList($data['EVIDENCE_STUDIES_LI'] ?? []),
            'EVIDENCE_RECOMMENDATIONS_LI' => $this->renderList($data['EVIDENCE_RECOMMENDATIONS_LI'] ?? []),
            'GUIDELINE_ANCHORS_LI' => $this->renderList($data['GUIDELINE_ANCHORS_LI'] ?? []),
            'EXTRA_INFO_HTML' => $data['EXTRA_INFO_HTML'] ?? '',
            'ADDITIONAL_SECTIONS_HTML' => $data['ADDITIONAL_SECTIONS_HTML'] ?? '',
        ];

        foreach ($replace as $token => $value) {
            $html = str_replace('[' . $token . ']', $value, $html);
        }

        $html = preg_replace('/\[(?!AI_CHAT_SECTION)[A-Z0-9_.]+\]/', '', $html) ?? '';

        return $html;
    }

    protected function renderList($items): string
    {
        if (is_string($items)) {
            return $items;
        }

        $items = $this->toArray($items);
        $parts = [];

        foreach ($items as $item) {
            $parts[] = '<li>' . $item . '</li>';
        }

        return implode('', $parts);
    }

    protected function renderAccordion($items, string $baseId): string
    {
        if (is_string($items)) {
            return $items;
        }

        $items = $this->toArray($items);
        $parts = [];

        foreach ($items as $index => $item) {
            $headerId = $baseId . 'h' . $index;
            $collapseId = $baseId . 'c' . $index;

            if (is_array($item) && (isset($item['q']) || isset($item['a']))) {
                $title = e((string) ($item['q'] ?? ''));
                $body = e((string) ($item['a'] ?? ''));
            } else {
                $title = e((string) $item);
                $body = $title;
            }

            $parts[] = sprintf(
                '<div class="accordion-item"><h2 class="accordion-header" id="%s"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#%s" aria-expanded="false" aria-controls="%s">%s</button></h2><div id="%s" class="accordion-collapse collapse" data-bs-parent="#%s"><div class="accordion-body"><p>%s</p></div></div></div>',
                $headerId,
                $collapseId,
                $collapseId,
                $title,
                $collapseId,
                $baseId,
                $body
            );
        }

        return implode('', $parts);
    }

    protected function toArray($value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if ($value === null || $value === '') {
            return [];
        }

        return [$value];
    }

    public function extractNavigationSections(string $html, Topic $topic): void
    {
        // Get admin-controlled navigation sections
        $adminSections = \App\Models\NavigationSection::active()->ordered()->get();
        
        // Filter sections that actually exist in the HTML and are enabled in admin
        $existingSections = [];
        foreach ($adminSections as $section) {
            if (strpos($html, 'id="' . $section->id . '"') !== false) {
                $existingSections[] = [
                    'id' => $section->id,
                    'title' => $section->title,
                    'icon' => $section->icon,
                ];
            }
        }
        
        // Store navigation sections in class property
        $this->navigationSections = $existingSections;
        
        // Debug log
        \Log::info('Navigation sections extracted', [
            'sections_count' => count($existingSections),
            'sections' => $existingSections,
            'html_length' => strlen($html),
            'admin_sections_count' => $adminSections->count(),
        ]);
    }

    protected function defaultTemplate(): ?Template
    {
        return Template::query()->where('is_default', true)->first();
    }
}



