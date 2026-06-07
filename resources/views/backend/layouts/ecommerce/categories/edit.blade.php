@extends('backend.layouts.app')

@section('title')
    || Edit Category
@endsection

@section('content')
    <div class="content-wrapper">
        <x-breadcrumbs title="Edit Category" subtitle="Update category details." :breadcrumbs="[['text' => 'Categories', 'url' => route('categories.index')]]" />

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card card-body">
                    <form method="POST" action="{{ route('categories.update', $category) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter category name">
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="form-control @error('description') is-invalid @enderror" placeholder="Optional description">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
