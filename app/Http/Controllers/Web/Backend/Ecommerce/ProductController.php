<?php

namespace App\Http\Controllers\Web\Backend\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Media;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::with(['category', 'subcategory', 'thumbnail'])->latest()->get();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('name', fn(Product $product) => $product->name)
                ->addColumn('category', fn(Product $product) => $product->category?->name ?? '—')
                ->addColumn('subcategory', fn(Product $product) => $product->subcategory?->name ?? '—')
                ->addColumn('old_price', fn(Product $product) => number_format($product->old_price, 2))
                ->addColumn('new_price', fn(Product $product) => number_format($product->new_price, 2))
                ->addColumn('action', function (Product $product) {
                    return view('components.action-buttons', [
                        'id'     => $product,
                        'show'   => 'products.show',
                        'edit'   => 'products.edit',
                        'delete' => true,
                    ])->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backend.layouts.ecommerce.products.index');
    }

    public function create()
    {
        $categories    = Category::orderBy('name')->get();
        $subcategories = Subcategory::with('category')->orderBy('name')->get();

        return view('backend.layouts.ecommerce.products.create', compact('categories', 'subcategories'));
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        $product = Product::create($validated);

        $this->uploadProductImages($product, $request->file('images'));

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }


    public function show(Product $product)
    {
        $product->load('images');

        return view('backend.layouts.ecommerce.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('images');
        $categories    = Category::orderBy('name')->get();
        $subcategories = Subcategory::with('category')->orderBy('name')->get();

        return view('backend.layouts.ecommerce.products.edit', compact('product', 'categories', 'subcategories'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        $product->update($validated);

        if ($request->hasFile('images')) {
            $lastOrder = $product->images()->max('order') ?? -1;
            $this->uploadProductImages($product, $request->file('images'), $lastOrder + 1);
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }
    public function destroy(Product $product)
    {
        foreach ($product->images as $media) {
            deleteFile($media->path);
        }

        $product->images()->delete();
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    private function uploadProductImages(Product $product, array $images, int $startOrder = 0): void
    {
        foreach ($images as $index => $image) {
            $path = uploadFile($image, 'uploads/products');

            $product->images()->create([
                'path'       => $path,
                'collection' => 'images',
                'order'      => $startOrder + $index,
            ]);
        }
    }

    public function destroyMedia(Media $media)
    {
        deleteFile($media->path);
        $media->delete();

        return response()->json(['success' => true]);
    }
}
