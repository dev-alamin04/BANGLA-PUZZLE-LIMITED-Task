@extends('backend.layouts.app')

@section('title')
    || Subcategories
@endsection

@section('content')
    <div class="content-wrapper">
        <x-breadcrumbs title="Subcategories" subtitle="Create and manage category subcategories." :breadcrumbs="[['text' => 'Subcategories', 'url' => route('subcategories.index')]]">
            <x-slot name="actions">
                <a href="{{ route('subcategories.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-circle"></i> Add Subcategory
                </a>
            </x-slot>
        </x-breadcrumbs>

        <div class="row">
            <div class="col-12">
                <div class="card card-body">
                    <div class="table-responsive">
                        <table class="table reloadSubcategoryTable table-hover " id="data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Description</th>
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
    @include('backend.layouts.ecommerce.subcategories.partials._subcategoriesJS')
@endsection
