<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @production
        <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js"
                data-cbid="98f953d5-0a52-41ef-b173-e0218b36bb3d" data-blockingmode="auto"
                type="text/javascript"></script>
    @endproduction
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="My Awesome App description">

    <link rel="icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="{{ Vite::asset('resources/images/icons/apple-touch-icon.png')}}" sizes="180x180">
    <link rel="mask-icon" href="{{ Vite::asset('resources/images/icons/mask-icon.svg')}}" color="#FFFFFF">
    <meta name="theme-color" content="#ffffff">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link rel="manifest" href="/build/manifest.webmanifest"/>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
@include('components.nudge-pwa')
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <img src="{{ Vite::asset('resources/images/icons/512x512.png')}}" alt="" width="30" height="30">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('el-meteringpoint') }}">{{__('Metering point') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('el-charges') }}">{{__('Charges') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('consumption') }}">{{__('Consumption') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('el-spotprices') }}">{{__('Spot prices') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('el') }}">{{__('Calculate your bill') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           href="{{ route('el-custom') }}">{{__('Scheme usage') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('totalprices') }}">{{ __('Total prices') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="function openPwaNudge() {
                            $('.box').css('z-index', 1055);
                            $('.box').css('display', 'block');
                            $('#pwaModal').css('z-index', 1055);
                            $('#pwaModal').modal('show');
                            $('.arrow').removeAttr('style');
                            $('.arrow').css('z-index', 1055); } openPwaNudge() ">{{ __('App') }}</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @endguest
                    @auth
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <main class="py-4">
        @include('errors')
        @yield('content')
    </main>

    <x-modal name="confirm-update-page" focusable>
        <div class="pwa-toast">
            {{ __('New content available, click on reload button to update.') }}
            <div class="message">
                <button onclick="confirmUpdatePage()" id="updatebutton">
                    {{ __('Reload') }}
                </button>
                <button x-on:click="$dispatch('close')">
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </x-modal>


    <footer class="p-2 rounded bg-white shadow-sm w-100">
        @include('components.footer')
    </footer>
</div>
<script type="module">
    window.onload = function () {
        if (/Android|iPhone/i.test(navigator.userAgent)) {
            //first_visit inspired by https://stackoverflow.com/a/73461422
            let first_visit = false;
            checkFirstVisit();

            function checkFirstVisit() {
                if (localStorage.getItem('was_visited')) {
                    return;
                }
                first_visit = true;
                localStorage.setItem('was_visited', 1);
            }

            if (first_visit) {
                $('#pwaModal').css("z-index", 1055);
                $('#pwaModal').modal('show');
                $('.arrow').removeAttr("style");
                $('.arrow').css("z-index", 1055);
            }
        }

        var logoutForm = document.getElementById('logout-form');
        if(logoutForm) {
            logoutForm.addEventListener('submit', function(e) {
                // Logik for at rydde op i Service Worker
                if ('serviceWorker' in navigator) {
                    navigator.serviceWorker.ready.then((registration) => {
                        registration.active.postMessage({ action: 'clearCache' });
                    });
                }
            });
        }

        document.getElementById("updatebutton").onclick = function() {
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.ready.then((registration) => {
                    registration.waiting.postMessage({ action: 'skipWaiting' });
                });
            }
        };

        @yield('javaScript')
    }
</script>
</body>
</html>
