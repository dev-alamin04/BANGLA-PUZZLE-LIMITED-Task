@extends('backend.layouts.app')
@section('title', isset($cms_content) ? 'Edit CMS Content' : 'Create CMS Content')

@section('content')
    <div class="content-wrapper">
        {{-- <x-breadcrumbs title="{{ isset($cms_content) ? 'Edit CMS Content' : 'Add New CMS Content' }}" :breadcrumbs="[
            ['text' => 'CMS Content', 'url' => route('admin.cms_contents.index')],
            ['text' => isset($cms_content) ? 'Edit' : 'Create']
        ]" /> --}}

         <x-breadcrumbs title="{{ isset($cms_content) ? 'Edit CMS Content' : 'Add New CMS Content' }}"  :breadcrumbs="[
            ['text' => 'Promocode list', 'url' => route('promocodes.index')]
        ]" />

        <div class="card p-4 shadow-sm">
            <form
                action="{{ isset($cms_content) ? route('admin.cms_contents.update', $cms_content->id) : route('admin.cms_contents.store') }}"
                method="POST" enctype="multipart/form-data" id="cmsForm">
                @csrf
                @if(isset($cms_content))
                    @method('PUT')
                @endif

                <div class="row mb-3">
                    <!-- Page Select -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Page</label>
                        <select name="page" id="page" class="form-select">
                            <option value="">-- Select Page --</option>
                            @foreach($pages as $pageEnum)
                                <option value="{{ $pageEnum->value }}" {{ old('page', $cms_content->page ?? '') === $pageEnum->value ? 'selected' : '' }}>
                                    {{ ucfirst($pageEnum->value) }}
                                </option>
                            @endforeach
                        </select>
                        @error('page') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <!-- Section Select -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Section</label>
                        <select name="section" id="section" class="form-select" {{ old('page', $cms_content->page ?? '') ? '' : 'disabled' }}>
                            <option value="">-- Select Section --</option>
                            @php
                                $selectedPage = old('page', $cms_content->page ?? null);
                                $selectedSection = old('section', $cms_content->section ?? null);
                                $sectionsForPage = $sectionConfig[$selectedPage] ?? [];
                            @endphp
                            @foreach($sectionsForPage as $sectionKey => $fields)
                                <option value="{{ $sectionKey }}" {{ $selectedSection === $sectionKey ? 'selected' : '' }}>
                                    {{ str_replace('_', ' ', strtoupper($sectionKey)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('section') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <!-- Dynamic Fields -->
                <div class="row mt-3" id="dynamicFields"></div>

                <!-- Dynamic Items -->
                <div class="mt-4" id="itemSection" style="display:none;">
                    <h5 class="fw-bold mb-3">Section Items</h5>
                    <div id="dynamicItems"></div>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="addItemBtn">
                        <i class="fas fa-plus"></i> Add Item
                    </button>
                </div>


                <div class="text-end mt-3">
                    <a href="{{ route('admin.cms_contents.index') }}" class="btn btn-secondary px-4 me-2">Back</a>
                    <button type="submit" class="btn btn-primary px-4">
                        {{ isset($cms_content) ? 'Update' : 'Save' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('backend.layouts.cms.dynamic-fields')
@endsection