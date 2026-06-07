@extends('backend.layouts.app')

@section('title')
    || Create Subcategory
@endsection

@section('content')
    <div class="content-wrapper">
        <x-breadcrumbs title="Create Subcategory" subtitle="Add a new subcategory for a category." :breadcrumbs="[['text' => 'Subcategories', 'url' => route('subcategories.index')]]" />

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card card-body">
                    <form method="POST" action="{{ route('subcategories.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select id="category_id" name="category_id"
                                class="form-control @error('category_id') is-invalid @enderror">
                                <option value="">Select category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Subcategory Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter subcategory name">
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea id="description" name="description" rows="4"
                                class="form-control @error('description') is-invalid @enderror" placeholder="Optional description">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="text-end">
                            <a href="{{ route('subcategories.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Save Subcategory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
