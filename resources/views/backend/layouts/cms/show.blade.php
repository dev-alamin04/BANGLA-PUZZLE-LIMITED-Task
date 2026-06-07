@extends('backend.layouts.app')
@section('title', 'CMS Content Details')

@section('content')
    <div class="content-wrapper">
        <x-breadcrumbs title="CMS Content Details" :breadcrumbs="[['text' => 'CMS Contents', 'url' => route('admin.cms_contents.index')]]" />


        <section class="py-3">
            <div class="container-fluid">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-red text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            {{ str_replace('_', ' ', ucfirst($cms_content->section)) }} —
                            {{ str_replace('_', ' ', ucfirst($cms_content->page)) }}
                        </h5>
                        <span class="badge {{ $cms_content->is_active ? 'bg-info' : 'bg-danger' }}">
                            {{ $cms_content->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                <tr>
                                    <th width="25%">Page</th>
                                    <td>{{ ucfirst(str_replace('_', ' ', $cms_content->page)) }}</td>
                                </tr>
                                <tr>
                                    <th>Section</th>
                                    <td>{{ ucfirst(str_replace('_', ' ', $cms_content->section)) }}</td>
                                </tr>

                                @php
                                    $sectionConfig = config('cms_sections');
                                    $fields = $sectionConfig[$cms_content->page][$cms_content->section]['fields'] ?? [];
                                    $itemFields = $sectionConfig[$cms_content->page][$cms_content->section]['items'] ?? [];
                                @endphp

                                @foreach($fields as $field)
                                    <tr>
                                        <th>{{ ucfirst(str_replace('_', ' ', $field)) }}</th>
                                        <td>
                                            @if(in_array($field, ['image', 'background_image']))
                                                @if($cms_content->$field)
                                                    <img src="{{ asset($cms_content->$field) }}" alt="{{ $field }}"
                                                        class="img-thumbnail" style="max-height:120px;">
                                                @else
                                                    <span class="text-muted">No image</span>
                                                @endif
                                            @elseif(in_array($field, ['description', 'subtitle']))
                                                {!! nl2br(e($cms_content->$field ?? '—')) !!}
                  
                                            @elseif(in_array($field, ['video']))
                                                @if($cms_content->$field)
                                                    <video width="150" height="100" class="mt-2 rounded border d-block" controls>
                                                        <source src="{{ asset($cms_content->$field) }}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @else
                                                    <span class="text-muted">No video available</span>
                                                @endif
                                            @else
                                                {{ $cms_content->$field ?? '—' }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                {{-- Optional Dynamic Items --}}
                                @if($cms_content->items && $cms_content->items->count())
                                    <tr>
                                        <th>Items</th>
                                        <td>
                                            <div class="row">
                                                @foreach($cms_content->items as $item)
                                                    <div class="col-md-6 mb-3">
                                                        <div class="card h-100 shadow-sm" style="border: 1px dotted #ff6610">
                                                            <div class="card-body">
                                                                @foreach($itemFields as $itemField)
                                                                    <div class="mb-2">
                                                                        <strong>{{ ucfirst(str_replace('_', ' ', $itemField)) }}:</strong>

                                                                        @php
                                                                            $value = $item->$itemField ?? '—';
                                                                        @endphp

                                                                        @if(in_array($itemField, ['image', 'icon']))
                                                                            @if($value)
                                                                                {{-- <img src="{{ asset($value) }}" alt="{{ $itemField }}"
                                                                                    class="img-thumbnail rounded mt-1"
                                                                                    style="max-height:100px;"> --}}
                                                                                <a href="{{ asset($value) }}" target="_blank"
                                                                                    class="btn btn-sm btn-outline-primary">
                                                                                    <i class="fas fa-image"></i> View Image
                                                                                </a>
                                                                            @else
                                                                                <span class="text-muted">No image</span>
                                                                            @endif
                                                                            {{-- hover_video --}}
                                                                        @elseif(in_array($itemField, ['hover_video']))
                                                                            @if($value)
                                                                                <a href="{{ asset($value) }}" target="_blank"
                                                                                    class="btn btn-sm btn-outline-primary">
                                                                                    <i class="fas fa-video"></i> View Video
                                                                                </a>
                                                                            @else
                                                                                <span class="text-muted">No video available</span>
                                                                            @endif
                                                                        @elseif(in_array($itemField, ['description']))
                                                                            {!! nl2br(e($value)) !!}
                                                                        @else
                                                                            {{ $value }}
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.cms_contents.edit', $cms_content->id) }}" class="btn btn-primary px-4">
                                <i class="fas fa-edit me-1"></i> Edit
                            </a>
                            <a href="{{ route('admin.cms_contents.index') }}" class="btn btn-secondary px-4">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection