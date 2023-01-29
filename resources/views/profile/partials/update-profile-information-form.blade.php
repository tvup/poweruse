<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150" src="https://cdn-icons-png.flaticon.com/512/149/149071.png">
                        <span class="font-weight-bold">{{ $user->name }}</span>
                        <span class="text-black-50">{{ $user->email }}</span>
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="row mt-2">
                            @if (session('status') === 'profile-updated')
                                <div class="alert alert-success" role="alert">
                                    {{ __('Profile updated.') }}
                                </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right">{{ __('Profile Settings') }}</h4>
                            </div>
                            <div class="col-md-6 labels mt-2"><label class="labels">{{ __('Name') }}</label><input type="text" class="form-control" name="name" value="{{old('name', $user->name)}}"></div>
                            <div class="col-md-6 labels mt-2"><label class="labels">{{ __('Email') }}</label><input type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}"></div>
                            <div class="col-md-12 labels mt-2"><label class="labels">{{ __('Refresh token') }}</label><input type="password" class="form-control" name="refresh_token" value="{{ old('refresh_token', Illuminate\Support\Str::repeat('*', Illuminate\Support\Str::length($user->refresh_token ?: ''))) }}"></div>
                                <div class="col-md-12">
                                    <label class="labels mt-2">{{ __('Language') }}</label>
                                    <div class="form-check form-check">
                                        <label class="form-check-label" for="localEnUs">🇺🇸 {{ __('English') }}</label>
                                        <input class="form-check-input" {{ $user->locale === 'en_US' ? 'checked' : '' }} id="localEnUs" type="radio" name="locale" value="en_US">
                                    </div>
                                    <div class="form-check form-check">
                                        <label class="form-check-label" for="localeDaDk">🇩🇰 {{ __('Danish') }}</label>
                                        <input class="form-check-input" {{ $user->locale === 'da_DK' ? 'checked' : '' }} id="localeDaDk" type="radio" name="locale" value="da_DK">
                                    </div>
                                </div>
                        </div>
                        <div class="mt-5 text-left"><button  class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
