@extends('layouts.app')

@section('content')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-50">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="hero-badge mb-3">
                    <i class="fa-solid fa-bolt me-1"></i> {{ __('Smart electricity tools') }}
                </div>
                <h1 class="hero-title">{{ __('Welcome to') }} PowerUse</h1>
                <p class="hero-description">
                    {{ __('Here you will find tools for calculation on electricity usage and tools to retrieve data from operators in the energy market') }}
                </p>
                <div class="d-flex gap-3 mt-4">
                    <a href="{{ route('el') }}" class="btn btn-primary btn-lg">
                        <i class="fa-solid fa-calculator me-2"></i>{{ __('Calculate your bill') }}
                    </a>
                    <a href="{{ route('totalprices') }}" class="btn btn-outline-secondary btn-lg">
                        {{ __('Total prices') }}
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <p class="page-subtitle mb-2">
                    <i class="fa-solid fa-circle-play me-1"></i>
                    {{ __('How to get your refresh token from Energioverblik') }}
                </p>
                <div class="hero-video-container">
                    <video controls loop name="media" class="hero-video">
                        <source src="{{ Vite::asset('resources/videos/opret_token.webm') }}" type="video/webm">
                    </video>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5 mb-4">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-card">
                <div class="card-icon mb-3"><i class="fa-solid fa-bolt"></i></div>
                <h3 class="feature-title">{{ __('Consumption') }}</h3>
                <p class="feature-desc">{{ __('Retrieve and analyze your electricity consumption data') }}</p>
                <a href="{{ route('consumption') }}" class="feature-link">{{ __('View consumption') }} <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <div class="card-icon mb-3"><i class="fa-solid fa-chart-line"></i></div>
                <h3 class="feature-title">{{ __('Spot prices') }}</h3>
                <p class="feature-desc">{{ __('View current and historical spot prices for DK1 and DK2') }}</p>
                <a href="{{ route('el-spotprices') }}" class="feature-link">{{ __('View prices') }} <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <div class="card-icon mb-3"><i class="fa-solid fa-gauge"></i></div>
                <h3 class="feature-title">{{ __('Metering point') }}</h3>
                <p class="feature-desc">{{ __('Manage and view your metering point data') }}</p>
                <a href="{{ route('el-meteringpoint') }}" class="feature-link">{{ __('Manage') }} <i class="fa-solid fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>
@endsection
