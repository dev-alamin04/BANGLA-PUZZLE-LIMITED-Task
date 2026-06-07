@extends('backend.layouts.app')

@section('title')
    || System Settings
@endsection

@section('content')
    <div class="content-wrapper">
        <x-breadcrumbs title="System Settings" subtitle="Manage system-wide settings and configurations." :breadcrumbs="[['text' => 'System Settings', 'url' => route('system.index')]]" />
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-4 card-style">
                    <div class="card card-body">
                        <form method="POST" action="{{ route('system.update') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="mt-3 col-md-6">
                                    <div class="input-style-1">
                                        <label for="system_name">System Name:</label>
                                        <input type="text" id="system_name" name="system_name"
                                            class="form-control @error('system_name') is-invalid @enderror"
                                            placeholder="System Name" value="{{ $setting->system_name ?? '' }}">
                                        @error('system_name')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mt-3 col-md-6">
                                    <div class="input-style-1">
                                        <label for="email">System Email:</label>
                                        <input type="email" id="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="System Email" value="{{ $setting->email ?? '' }}">
                                        @error('email')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 col-md-12">
                                <div class="input-style-1">
                                    <label for="copyright_text">Copy Rights Text:</label>
                                    <input type="text" id="copyright_text" name="copyright_text"
                                        class="form-control @error('copyright_text') is-invalid @enderror"
                                        placeholder="Copy Rights Text" value="{{ $setting->copyright_text ?? '' }}">
                                    @error('copyright_text')
                                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="row">
                                <div class="mt-3 col-12">
                                    <div class="input-style-1">
                                        <label for="description">Description:</label>
                                        <textarea name="description" id="description" rows="4"
                                            class="form-control @error('description') is-invalid @enderror" placeholder="Description">{{ $setting->description ?? '' }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mt-3 col-md-6">
                                    <div class="input-style-1">
                                        <label for="logo">Logo:</label>
                                        <input type="file" id="logo" name="logo"
                                            class="dropify @error('logo') is-invalid @enderror"
                                            data-default-file="{{ asset($setting->logo ?? 'backend/assets/img/image_placeholder.png') }}">
                                    </div>
                                    @error('logo')
                                        <span class="text-danger"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="mt-3 col-md-6">
                                    <div class="input-style-1">
                                        <label for="favicon">Favicon:</label>
                                        <input type="file" id="favicon" name="favicon"
                                            class="dropify @error('favicon') is-invalid @enderror"
                                            data-default-file="{{ asset($setting->favicon ?? 'backend/assets/img/image_placeholder.png') }}">
                                    </div>
                                    @error('favicon')
                                        <span class="text-danger"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="mt-3 col-12">
                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('admin.dashboard') }}" class="btn btn-danger me-3">Cancel</a>
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
