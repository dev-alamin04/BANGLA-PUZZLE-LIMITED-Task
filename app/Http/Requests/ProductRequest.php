<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => $this->generateSlug(),
        ]);
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $productId = $this->route('product')?->id;

        return [
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'name'           => 'required|string|max:255',
            'slug'           => 'required|string|unique:products,slug' . ($productId ? ",{$productId}" : ''),
            'description'    => 'nullable|string|max:2000',
            'old_price'      => 'required|numeric|min:0',
            'new_price'      => 'required|numeric|min:0',
            'images'         => $isUpdate ? 'nullable|array' : 'required|array|min:1',
            'images.*'       => 'image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ];
    }

    public function messages(): array
    {
        return [
            'images.required' => 'At least one image is required.',
            'images.*.image'  => 'Each file must be a valid image.',
            'images.*.mimes'  => 'Only jpeg, png, jpg, gif, webp formats are allowed.',
            'images.*.max'    => 'Each image must not exceed 4MB.',
        ];
    }

    private function generateSlug(): string
    {
        $slug      = Str::slug($this->name ?? '');
        $base      = $slug;
        $counter   = 1;
        $productId = $this->route('product')?->id;

        while (
            Product::where('slug', $slug)->when($productId, fn($q) => $q->where('id', '!=', $productId))->exists()
        ) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }
}