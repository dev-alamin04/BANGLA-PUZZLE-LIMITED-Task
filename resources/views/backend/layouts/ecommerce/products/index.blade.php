@extends('backend.layouts.app')

@section('title')
    || Products
@endsection

@section('content')
    <div class="content-wrapper">
        <x-breadcrumbs title="Products" subtitle="Browse products grouped by subcategory." :breadcrumbs="[['text' => 'Products', 'url' => route('products.index')]]">
            <x-slot name="actions">
                <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus-circle"></i> Add Product
                </a>
            </x-slot>
        </x-breadcrumbs>

        <div class="row">
            <div class="col-12">
                <div class="card card-body">
                    <div class="table-responsive">
                        <table class="table reloadProductTable table-hover " id="data-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Old Price</th>
                                    <th>New Price</th>
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
    @include('backend.layouts.ecommerce.products.partials._productsJS')
@endsection
