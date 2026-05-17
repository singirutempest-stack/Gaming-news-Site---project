@foreach (['success', 'danger', 'warning', 'info'] as $type)
    @if (session($type))
        <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
            {{ session($type) }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
@endforeach

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>{{ __('app.validation_error') }}</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
