<?php
namespace App\Http\Requests\Setting;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class EmailTemplateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tenantId   = $this->user()->tenant_id;
        $templateId = $this->route('email_template')?->id;

        return [
            'postbox_id'           => ['nullable', 'exists:postbox_settings,id'],
            'title'                => ['required', 'string', 'max:255'],
            'subject'              => ['required', 'string', 'max:255'],
            'body'                 => ['required', 'string'],

            // UNIQUE PER TENANT
            'template_type'        => ['required', 'string', 'max:50',
                Rule::unique('email_templates', 'template_type')->where(fn($q) => $q->where('tenant_id', $tenantId))->ignore($templateId),
            ],

            'headline_banner'      => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:40960'], // 40MB
            'template_variables'   => ['nullable', 'array'],
            'template_variables.*' => ['string'],
            'metadata'             => ['nullable', 'array'],
            'is_active'            => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'template_type.unique' =>
            'This template type already exists for your organization.',
        ];
    }
}
