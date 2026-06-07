<?php
namespace App\Http\Requests\Setting;

use App\Http\Requests\BaseRequest;

class CompanyDetailsUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                      => ['required', 'string', 'max:100'],
            'company_type'              => ['nullable', 'string', 'max:50'],
            'website'                   => ['nullable', 'url'],
            'city'                      => ['nullable', 'string', 'max:100'],
            'address'                   => ['nullable', 'string'],
            'employees_number_id'       => ['nullable', 'exists:employees_numbers,id'],
            'about'                     => ['nullable', 'string'],
            'mission'                   => ['nullable', 'string'],
            'logo_path'                 => ['nullable', 'file', 'mimes:jpeg,png,jpg,webp,svg', 'max:20480'], // 20MB

            // Benefits
            'benefits'                  => ['nullable', 'array'],
            'benefits.*.title'          => ['required', 'string', 'max:100'],
            'benefits.*.icon'           => ['nullable', 'file', 'mimes:svg,png,jpg,jpeg,webp', 'max:10240'],

            // Social links
            'social_links'              => ['nullable', 'array'],
            'social_links.*.platform'   => ['required', 'string', 'max:50'],
            'social_links.*.url'        => ['required', 'url'],
            'social_links.*.sort_order' => ['nullable', 'integer'],
            'is_ai_enabled'             => ['nullable', 'boolean'],
        ];
    }
}
