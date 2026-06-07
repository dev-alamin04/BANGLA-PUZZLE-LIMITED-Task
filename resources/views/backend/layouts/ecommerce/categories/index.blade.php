@extends('backend.layouts.app')

@section('title')
    || Categories
@endsection

@section('content')
    <div class="content-wrapper">
        <x-breadcrumbs title="Categories" subtitle="Create and manage product categories." :breadcrumbs="[['text' => 'Categories', 'url' => route('categories.index')]]">
            <x-slot name="actions">
                <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-circle"></i> Add Category
                </a>
            </x-slot>
        </x-breadcrumbs>

        <div class="row">
            <div class="col-12">
                <div class="card card-body">
                    <div class="table-responsive">
                        <table class="table reloadCategoryTable table-hover " id="data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Subcategories</th>
                                    <th>Products</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('backend.layouts.ecommerce.categories.partials._categoriesJS')
@endsection
