@extends("layouts.app")

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div class="card-icon me-3"><i class="fa-solid fa-gauge"></i></div>
                <div>
                    <h2 class="card-title">{{ __('Metering point') }}</h2>
                    <p class="page-subtitle mb-0">{{ __('Manage your electricity metering points') }}</p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="app">
                <metering-point  :auth-user="{{ Auth::check() ? json_encode(Auth::user()) : "'no'" }}" />
            </div>
        </div>
    </div>
</div>

@endsection