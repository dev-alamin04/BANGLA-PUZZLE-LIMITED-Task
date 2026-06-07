<?php

namespace App\Http\Controllers\Web\Backend\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Category::withCount(['subcategories', 'products'])->latest()->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('name', fn(Category $category) => $category->name)
                ->addColumn('description', fn(Category $category) => $category->description ?? '—')
                ->addColumn('subcategories_count', fn(Category $category) => $category->subcategories_count)
                ->addColumn('products_count', fn(Category $category) => $category->products_count)
                ->addColumn('action', function (Category $category) {
                    return view('components.action-buttons', [
                        'id' => $category->id,
                        'edit' => 'categories.edit',
                        'delete' => true,
                    ])->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.layouts.ecommerce.categories.index');
    }

    public function create()
    {
        return view('backend.layouts.ecommerce.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => $this->makeSlug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('backend.layouts.ecommerce.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($category->id),
            ],
            'description' => 'nullable|string|max:1000',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => $this->makeSlug($request->name, $category->id),
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        foreach ($category->subcategories()->with('products')->get() as $subcategory) {
            foreach ($subcategory->products as $product) {
                deleteFile($product->image_path);
            }
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    private function makeSlug(string $value, ?int $ignoreId = null): string
    {
        $slug = Str::slug($value);
        $base = $slug;
        $counter = 1;

        while (Category::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }
}
