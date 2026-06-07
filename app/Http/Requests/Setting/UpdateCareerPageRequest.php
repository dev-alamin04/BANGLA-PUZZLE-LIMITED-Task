<?php
namespace App\Http\Requests\Setting;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdateCareerPageRequest extends BaseRequest
{

    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        $tenantId = $this->user()?->tenant?->id;

        return [
            'slug'                      => ['required', 'string', 'max:100',
                Rule::unique('tenants', 'slug')->ignore($tenantId),
            ],
            'career_page_custom_domain' => ['nullable', 'string', 'max:255'],
            'career_page_banner_path'   => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:40960'], // 40MB

            // Multiple Media
            'media'                     => ['nullable', 'array'],
            'media.*'                   => ['file', 'max:204800'], // 200MB
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('slug')) {
            $this->merge([
                'slug' => Str::slug($this->slug),
            ]);
        }
    }
    //  Custom attribute names (optional but nice)
    public function attributes(): array
    {
        return [
            'slug'                      => 'career page slug',
            'career_page_custom_domain' => 'career page custom domain',
            'career_page_banner'        => 'career page banner',
            'media.*'                   => 'career page media file',
        ];
    }
}
