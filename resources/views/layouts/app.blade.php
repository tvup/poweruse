<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="My Awesome App description">

    <link rel="icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/assets/images/icons/apple-touch-icon.png" sizes="180x180">
    <link rel="mask-icon" href="/assets/images/icons/mask-icon.svg" color="#FFFFFF">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="manifest" href="/build/manifest.webmanifest" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    <img src="{{ Vite::asset('resources/images/icons/512x512.png')}}" alt="" width="30" height="30">
                    {{ config('app.name', 'Laravel') }}
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a  class="nav-link" href="{{ route('el-meteringpoint') }}">{{__('Metering point') }}</a>
                        </li>
                        <li class="nav-item">
                            <a  class="nav-link" href="{{ route('el-charges') }}">{{__('Charges') }}</a>
                        </li>
                        <li class="nav-item">
                            <a  class="nav-link" href="{{ route('consumption') }}">{{__('Consumption') }}</a>
                        </li>
                        <li class="nav-item">
                            <a  class="nav-link" href="{{ route('el-spotprices') }}">{{__('Spot prices') }}</a>
                        </li>
                        <li class="nav-item">
                            <a  class="nav-link" href="{{ route('el') }}">{{__('Calculate your bill') }}</a>
                        </li>
                        <li class="nav-item">
                            <a  class="nav-link" href="{{ route('el-custom') }}">{{__('Beregn prisen for et bestemt forbrug i dag') }}</a>
                        </li>
                        <li class="nav-item">
                            <a  class="nav-link" href="{{ route('totalprices') }}">{{ __('Total prices') }}</a>
                        </li>
                        @auth
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            {{ __('Profile') }}
                                        </a>

                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @include('errors')
            @yield('content')
        </main>
    </div>
</body>
</html>
