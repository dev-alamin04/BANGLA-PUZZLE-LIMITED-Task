@extends('backend.layouts.app')
@section('title')
    || Dynamic Pages
@endsection

@section('content')
    <div class="content-wrapper">
        <x-breadcrumbs title="Dynamic Pages" subtitle='Manage all dynamic pages across the platform.' :breadcrumbs="[['text' => 'Dynamic Pages', 'url' => route('dynamic_page.index')]]" />

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <x-table-header title="Dynamic Pages" subtitle="Manage all dynamic pages across the platform." />
                        <div class="table-responsive w-100">
                            <table class="table reloadDynamicPageTable table-hover" id="data-table">
                                <thead align="middle">
                                    <tr>
                                        <th>#</th>
                                        <th>Page Title</th>
                                        <th>Page Content</th>
                                        <th>Status</th>
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
    </div>
@endsection

@section('modal')
    <x-status-modal />
@endsection

@section('script')
    @include('backend.layouts.settings.dynamic_page.partials._dynamicPageJS')
@endsection
