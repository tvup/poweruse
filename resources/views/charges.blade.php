@extends("layouts.app")

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div class="card-icon me-3"><i class="fa-solid fa-file-invoice"></i></div>
                <div>
                    <h2 class="card-title">{{ __('Get charges for metering point') }}</h2>
                    <p class="page-subtitle mb-0">{{ __('View charges for your metering point') }}</p>
                </div>
            </div>
        </div>
        @if($data)
        <div class="data-panel">
            <div class="data-panel-header" onclick="this.parentElement.querySelector('.data-panel-body').classList.toggle('d-none')">
                <span class="data-panel-title"><i class="fa-solid fa-table me-2"></i>{{ __('Results') }}</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="data-panel-body">
                <pre>{{ json_encode($data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
            <form name="save-charges-form" id="save-charges-form" method="post" >
                {{ csrf_field() }}
                <button type="submit" class="btn btn-primary" @click="createCharges();">{{ __('Save to DB') }}</button>
            </form>
        @endif
        <div id="app">
            <charge :auth-user="{{ Auth::check() ? json_encode(Auth::user()) : "'no'" }}" />
        </div>
    </div>
</div>

@endsection
