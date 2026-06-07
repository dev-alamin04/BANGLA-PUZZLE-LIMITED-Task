@extends('backend.layouts.app')
@section('title') CMS Contents || Admin @endsection

@section('content')
    <div class="content-wrapper">
        <x-breadcrumbs title="CMS Contents" :breadcrumbs="[['text' => 'CMS Contents', 'url' => route('admin.cms_contents.index')]]" />

        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <x-table-header title="CMS Contents" :route="route('admin.cms_contents.create')" />
                        <div class="table-responsive w-100">
                            <table class="table reloadAdminTable table-hover" id="cms-table">
                                <thead>
                                    <tr>
                                        <th>S\L</th>
                                        <th>Page</th>
                                        <th>Section</th>
                                        <th>Main Title / Title</th>
                                        <th>Status</th>
                                        <th class="text-center">Action</th>
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
    @include('backend.layouts.cms._change_cms_status_modal')
@endsection

@section('script')
    @include('backend.layouts.cms._cmsJS')
@endsection