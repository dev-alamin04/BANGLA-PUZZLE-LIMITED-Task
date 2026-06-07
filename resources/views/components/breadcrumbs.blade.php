@props([
    'title' => 'Page Title',
    'subtitle' => null,
    'breadcrumbs' => null,
])

<div class="row justify-content-center">
    <div class="col-12">
        <div class="dashboard_header mb_10">
            <div class="row align-items-center">
                <!-- Left Section-->
                <div class="col-lg-6">
                    <div>
                        <h3 class="mb-0 text-primary">{!! $title !!}</h3>
                        @if ($subtitle)
                            <p class="text-muted mb-0 text-sm">{{ $subtitle }}</p>
                        @endif
                    </div>
                </div>

                <div class="col-lg-6 text-end">
                    <!-- Breadcrumbs -->
                    @if (!empty($breadcrumbs))
                        <div class="dashboard_breadcam">
                            <p class="mb-1">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>

                                @foreach ($breadcrumbs as $breadcrumb)
                                    <i class="fas fa-caret-right"></i>
                                    @if (isset($breadcrumb['url']))
                                        <a href="{{ $breadcrumb['url'] }}">
                                            {{ $breadcrumb['text'] }}
                                        </a>
                                    @else
                                        <span>{{ $breadcrumb['text'] }}</span>
                                    @endif
                                @endforeach
                            </p>
                        </div>
                    @endif

                    <!-- Actions -->
                    @isset($actions)
                        <div class="d-flex justify-content-end gap-2 mt-2">
                            {{ $actions }}
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>
