<?php

namespace App\Http\Controllers\Web\Backend\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class SubcategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Subcategory::with('category')->latest()->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('category', fn(Subcategory $subcategory) => $subcategory->category?->name ?? '—')
                ->addColumn('name', fn(Subcategory $subcategory) => $subcategory->name)
                ->addColumn('description', fn(Subcategory $subcategory) => $subcategory->description ?? '—')
                ->addColumn('products', fn(Subcategory $subcategory) => $subcategory->products()->count())
                ->addColumn('action', function (Subcategory $subcategory) {
                    return view('components.action-buttons', [
                        'id' => $subcategory->id,
                        'edit' => 'subcategories.edit',
                        'delete' => true,
                    ])->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.layouts.ecommerce.subcategories.index');
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('backend.layouts.ecommerce.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('subcategories', 'name')->where(fn ($query) => $query->where('category_id', $request->category_id)),
            ],
            'description' => 'nullable|string|max:1000',
        ]);

        Subcategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $this->makeSlug($request->name, $request->category_id),
            'description' => $request->description,
        ]);

        return redirect()->route('subcategories.index')->with('success', 'Subcategory created successfully.');
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::orderBy('name')->get();

        return view('backend.layouts.ecommerce.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('subcategories', 'name')
                    ->where(fn ($query) => $query->where('category_id', $request->category_id))
                    ->ignore($subcategory->id),
            ],
            'description' => 'nullable|string|max:1000',
        ]);

        $subcategory->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $this->makeSlug($request->name, $request->category_id, $subcategory->id),
            'description' => $request->description,
        ]);

        return redirect()->route('subcategories.index')->with('success', 'Subcategory updated successfully.');
    }

    public function destroy(Subcategory $subcategory)
    {
        foreach ($subcategory->products as $product) {
            deleteFile($product->image_path);
        }

        $subcategory->delete();

        return redirect()->route('subcategories.index')->with('success', 'Subcategory deleted successfully.');
    }

    private function makeSlug(string $value, int $categoryId, ?int $ignoreId = null): string
    {
        $slug = Str::slug($value);
        $base = $slug;
        $counter = 1;

        while (Subcategory::where('slug', $slug)
            ->where('category_id', $categoryId)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }
}
