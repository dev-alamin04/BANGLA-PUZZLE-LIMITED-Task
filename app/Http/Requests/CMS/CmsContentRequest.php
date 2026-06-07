<?php

namespace App\Http\Requests\CMS;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enum\Page;
use App\Enum\Section;
use Illuminate\Validation\Rules\Enum;

class CmsContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $page = $this->input('page');
        $section = $this->input('section');

        // Load section configuration dynamically
        $sectionConfig = config("cms_sections.{$page}.{$section}", []);
        $sectionFields = is_array($sectionConfig['fields'] ?? null) ? $sectionConfig['fields'] : $sectionConfig;
        $itemFields = $sectionConfig['items'] ?? [];

        // Base rules for page and section
        $rules = [
            'page' => ['required', new Enum(Page::class)],
            'section' => [
                'required',
                new Enum(Section::class),
                Rule::unique('cms_contents')
                    ->where(fn($q) => $q->where('page', $page)->where('section', $section))
                    ->ignore($this->route('cms_content')?->id),
            ],
        ];

        // Dynamic validation for section fields
        foreach ($sectionFields as $field) {
            $rules[$field] = match ($field) {
                'main_title', 'title', 'button_text', 'button_link' => ['nullable', 'string', 'max:255'],
                'subtitle', 'description' => ['nullable', 'string'],
                'background_image', 'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
                'video' => 'nullable|mimes:mp4,webm|max:51200', // max 50MB
                default => ['nullable'],
            };
        }

        // Dynamic validation for items
        if (!empty($itemFields)) {
            $rules['items'] = ['required', 'array', 'min:1'];
            $rules['items.*.id'] = ['nullable', 'integer', 'exists:cms_content_items,id'];

            foreach ($itemFields as $itemField) {
                $rules["items.*.$itemField"] = match ($itemField) {
                    'title' => ['required', 'string', 'max:255'],
                    'description' => ['nullable', 'string'],
                    'image',   'icon', => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:20480'],
                    'quantity' => ['nullable', 'integer'],
                    default => ['nullable'],
                };
            }
        }


        return $rules;
    }

    public function messages(): array
    {
        return [
            'page.required' => 'Please select a valid page.',
            'page.enum' => 'Invalid page selection.',
            'section.required' => 'Please select a valid section.',
            'section.enum' => 'Invalid section selection.',
            'section.unique' => 'This section already exists for the selected page.',
            'background_image.image' => 'The background image must be a valid image file.',
            'video.mimes' => 'The video file must be MP4 or WebM format.',
            'image.image' => 'The image must be a valid image file.',
            'items.required' => 'At least one item is required for this section.',
            'items.array' => 'Invalid items format.',
            'items.*.title.required' => 'Item title is required.',

        ];
    }
}
