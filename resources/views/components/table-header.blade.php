<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0  table-title">{{ $title }}</h4>

    @isset($route)
        <a href="{{ $route }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle"></i> {{ $buttonText ?? 'Add New' }}
        </a>
    @endisset
    @isset($subtitle)
        <p class="card-description" style="float: right">{{ $subtitle }} </p>
    @endisset
</div>
<hr>
