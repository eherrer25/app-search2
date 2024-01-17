@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-1"></i>
        {{ Session::get('success') }}
        @php
            Session::forget('success');
        @endphp
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(Session::has('warning'))
    <div class="alert alert-warning alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle me-1"></i>
        {{ Session::get('warning') }}
        @php
            Session::forget('warning');
        @endphp
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(Session::has('danger'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-octagon me-1"></i>
        {{ Session::get('danger') }}
        @php
            Session::forget('danger');
        @endphp
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif