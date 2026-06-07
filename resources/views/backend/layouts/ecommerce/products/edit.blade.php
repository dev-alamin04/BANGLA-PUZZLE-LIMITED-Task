@extends('backend.layouts.app')

@section('title')
    || Edit Product
@endsection

@section('content')
    <div class="content-wrapper">
        <x-breadcrumbs title="Edit Product" subtitle="Update product information."
            :breadcrumbs="[['text' => 'Products', 'url' => route('products.index')]]" />

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card card-body">
                    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select id="category_id" name="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror">
                                    <option value="">Select category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            @selected(old('category_id', $product->category_id) == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="subcategory_id" class="form-label">Subcategory</label>
                                <select id="subcategory_id" name="subcategory_id"
                                    class="form-control @error('subcategory_id') is-invalid @enderror">
                                    <option value="">Select subcategory</option>
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}"
                                            data-category="{{ $subcategory->category_id }}"
                                            @selected(old('subcategory_id', $product->subcategory_id) == $subcategory->id)>
                                            {{ $subcategory->category->name }} / {{ $subcategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subcategory_id')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name', $product->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter product name">
                            @error('name')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Product description">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="old_price" class="form-label">Old Price</label>
                                <input type="number" step="0.01" min="0" id="old_price" name="old_price"
                                    value="{{ old('old_price', $product->old_price) }}"
                                    class="form-control @error('old_price') is-invalid @enderror"
                                    placeholder="0.00">
                                @error('old_price')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="new_price" class="form-label">New Price</label>
                                <input type="number" step="0.01" min="0" id="new_price" name="new_price"
                                    value="{{ old('new_price', $product->new_price) }}"
                                    class="form-control @error('new_price') is-invalid @enderror"
                                    placeholder="0.00">
                                @error('new_price')
                                    <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        {{-- Existing images with individual delete --}}
                        @if ($product->images->isNotEmpty())
                            <div class="mb-3">
                                <label class="form-label">Current Images</label>
                                <div class="d-flex flex-wrap gap-3" id="existing-images">
                                    @foreach ($product->images as $media)
                                        <div class="position-relative" id="media-{{ $media->id }}">
                                            <img src="{{ asset($media->path) }}" alt="product"
                                                style="width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 1px solid #dee2e6;">
                                            <button type="button"
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 delete-media-btn"
                                                style="padding: 2px 6px; font-size: 11px;"
                                                data-id="{{ $media->id }}"
                                                data-url="{{ route('products.media.destroy', $media) }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Add more images --}}
                        <div class="mb-3">
                            <label class="form-label">
                                Add More Images
                                <small class="text-muted">(existing images will be kept)</small>
                            </label>
                            <input type="file" id="images" name="images[]" multiple
                                accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
                                class="form-control">
                            @error('images.*')
                                <span class="text-danger d-block mt-1"><strong>{{ $message }}</strong></span>
                            @enderror
                            <div id="image-preview" class="d-flex flex-wrap gap-2 mt-3"></div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.getElementById('images').addEventListener('change', function() {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';

            Array.from(this.files).forEach(function(file) {
                if (!file.type.startsWith('image/')) return;

                const reader = new FileReader();
                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.style.cssText = 'position:relative; display:inline-block;';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.cssText = 'width:100px; height:100px; object-fit:cover; border-radius:8px; border:1px solid #dee2e6;';

                    wrapper.appendChild(img);
                    preview.appendChild(wrapper);
                };
                reader.readAsDataURL(file);
            });
        });

        function filterSubcategories() {
            const categoryId = document.getElementById('category_id').value;
            document.querySelectorAll('#subcategory_id option[data-category]').forEach(function(option) {
                option.style.display = option.dataset.category === categoryId ? 'block' : 'none';
                if (option.dataset.category !== categoryId) option.selected = false;
            });
        }

        document.getElementById('category_id')?.addEventListener('change', filterSubcategories);
        window.addEventListener('DOMContentLoaded', filterSubcategories);

        $(document).on('click', '.delete-media-btn', function() {
    const mediaId = $(this).data('id');
    const url = $(this).data('url');

    $('#delete_id').val(mediaId);
    $('#deletemodal').modal('show');

    $('#delete_modal_clear').off('submit').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function() {
                $('#media-' + mediaId).remove();
                $('#deletemodal').modal('hide');
            },
            error: function() {
                $('#deletemodal').modal('hide');
                alert('Failed to delete image.');
            }
        });
    });
});
    </script>
@endsection