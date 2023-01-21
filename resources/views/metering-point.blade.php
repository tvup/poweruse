@extends("layouts.app")

@section('content')
<div class="container mt-4">
    <div id="app">
        <metering-point  :auth-user="{{ Auth::check() ? json_encode(Auth::user()) : "'no'" }}" />
    </div>
</div>

@endsection