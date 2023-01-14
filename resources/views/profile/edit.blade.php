@extends("layouts.app")

@section('content')
    <div class="card-header text-center font-weight-bold"">
    <h2>
        {{ __('Profile') }}
    </h2>
    </div>

    <div class="card-body">
        <div>
            <div class="p-4 bg-white">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="p-4 bg-white">
                @include('profile.partials.update-password-form')
            </div>

            <div class="p-4 bg-white">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
