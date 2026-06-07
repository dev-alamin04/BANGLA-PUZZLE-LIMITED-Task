@extends('backend.layouts.app')

@section('title')
    || Product Details
@endsection

@section('content')
    <div class="content-wrapper">
        <x-breadcrumbs title="Product Details" subtitle="View full product information."
            :breadcrumbs="[['text' => 'Products', 'url' => route('products.index')]]" />

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card card-body">
                    <div class="row g-4">

                        <div class="col-lg-4">
                            @if ($product->images->isNotEmpty())
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($product->images as $media)
                                        <img src="{{ asset($media->path) }}" alt="{{ $product->name }}"
                                            style="width: 110px; height: 110px; object-fit: cover; border-radius: 8px; border: 1px solid #dee2e6;">
                                    @endforeach
                                </div>
                            @else
                                <div class="text-muted">No images uploaded</div>
                            @endif
                            <h5 class="mt-3">{{ $product->name }}</h5>
                            <span class="badge bg-secondary">{{ $product->subcategory->name }}</span>
                        </div>

                        <div class="col-lg-8">
                            <div class="mb-3">
                                <strong>Category:</strong> {{ $product->category->name }}
                            </div>
                            <div class="mb-3">
                                <strong>Subcategory:</strong> {{ $product->subcategory->name }}
                            </div>
                            <div class="mb-3">
                                <strong>Description:</strong>
                                <p class="mb-0">{{ $product->description ?? 'No description provided.' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Old Price:</strong> {{ number_format($product->old_price, 2) }}
                            </div>
                            <div class="mb-3">
                                <strong>New Price:</strong> {{ number_format($product->new_price, 2) }}
                            </div>
                            <div class="d-flex gap-2 mt-4">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to Products</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection