@extends("layouts.app")

@section('content')
@if (Auth::check())
    <component :is="'script'">window.authUser={!! json_encode(Auth::user()); !!};</component>
@else
    <component :is="'script'">window.authUser=null;</component>
@endif
<div id="app">
    <metering-point  />
</div>

@endsection