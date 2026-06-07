@extends('backend.layouts.app')

@section('title', 'Dashboard')

@push('style')
    <style>
        .rounded-lg {
            border-radius: 0.8rem;
        }

        .metric-card {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .metric-label {
            color: #F2F3F5;
            font-size: 1rem;
        }

        .chart-card {
            background: #fff;
            border: 1px solid #DFE1E7;
            border-radius: 0.8rem;
            padding: 20px;
            height: 100%;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #DFE1E7;
        }

        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .table-card {
            background: #fff;
            border: 1px solid #DFE1E7;
            border-radius: 0.8rem;
            padding: 20px;
        }

        .search-box {
            display: flex;
            align-items: center;
            background: #f8f9fa;
            border: 1px solid #DFE1E7;
            border-radius: 6px;
            padding: 8px 12px;
            max-width: 300px;
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            padding-left: 8px;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-badge.active {
            background: #d4edda;
            color: #155724;
        }

        .status-badge.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-badge.closed {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
@endpush

@section('content')
    <x-breadcrumbs title="Welcome back, {{ Auth::user()?->name }}!" subtitle="Overview of platform activity and key metrics.">
    </x-breadcrumbs>

    @include('backend.layouts.dashboard.partials._metric_card')
@endsection
