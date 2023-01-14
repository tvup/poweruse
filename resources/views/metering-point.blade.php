@extends("layouts.app")

@section('content')
@if (Auth::check())
    <script>window.authUser={!! json_encode(Auth::user()); !!};</script>
@else
    <script>window.authUser=null;</script>
@endif
<div id="app">
    <metering-point  />
</div>

@endsection