@extends("layouts.app")

@section('content')
<div id="app">
    <metering-point  :auth-user="{{ Auth::check() ? json_encode(Auth::user()) : "'no'" }}" />
</div>

@endsection