<?php

namespace App\Services;

use App\Models\Section;
use App\Models\SectionField;
use Illuminate\Support\Arr;

class SectionTemplateService
{
    /**
     * Create a section from a template for a given page
     */
    public static function createSectionFromTemplate($page, string $type): Section
    {
        $templates = config('sections'); // Load templates from config

        if (!isset($templates[$type])) {
            throw new \Exception("Section template [{$type}] not found in config/sections.php");
        }

        $template = $templates[$type];

        // Create section
        $section = $page->sections()->create([
            'section_type' => $type,
            'layout' => Arr::get($template, 'layouts.0', null),
            'is_active' => true,
            'order_index' => ($page->sections()->max('order_index') ?? 0) + 1,
        ]);

        // Create fields
        foreach ($template['fields'] as $field) {
            $initialValue = $field['type'] === 'repeater' ? json_encode([]) : null;

            SectionField::create([
                'section_id' => $section->id,
                'field_key' => $field['key'],
                'field_type' => $field['type'],
                'field_value' => $initialValue,
                'order_index' => 0,
            ]);
        }


        return $section;
    }
}
