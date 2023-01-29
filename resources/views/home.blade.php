@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Welcome to PowerUse') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>{{ __('Here you\'ll find tools for calculation on electricity usage and tools to retrieve data from operators in the energy market') }}</p>
                    <p>{{ __('Below you can find a video on how to retrieve a refresh token from energioverblik which is used to retrieve consumption and static data for your metering point') }}</p>
                    <video width="340" height="250" controls autoplay loop name="media" class="video-size">
                        <source src="{{ Vite::asset('resources/videos/opret_token.webm') }}" type="video/webm">
                    </video>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
