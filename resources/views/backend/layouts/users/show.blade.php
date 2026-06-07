@extends('backend.layouts.app')
@section('title')
    User Details || Admin
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="dashboard_header mb_10">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="dashboard_header_title">
                                <h3>User Details</h3>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="dashboard_breadcam text-end">
                                <x-back-button />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- User Info Card --}}
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <img src="{{ $user->avatar_path ?? $user->profile_photo_url }}" alt="Avatar"
                            class="rounded-circle mb-3" width="120" height="120">
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <p class="text-muted">{{ $user->email }}</p>
                        <p class="text-muted">{{ $user->phone ?? 'N/A' }}</p>
                        <p>Status:
                            @if ($user->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Disabled</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
