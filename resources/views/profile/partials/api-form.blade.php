<section>
    <form method="get" action="{{ route('api.create') }}" >
        @csrf
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150" src="{{ Vite::asset('resources/images/key_807241.png')}}">
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="row mt-2">
                            @if (session('status') === 'api-token-created')
                                <div class="alert alert-success" role="alert">
                                    {{ __('API-credentials created') }}
                                </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right"> {{ __('Create API-access') }}</h4>
                            </div>
                            <div class="col-md-12"><label class="labels">{{ __('Access token') }}</label><input type="text" class="form-control" name="api_access_token" value="{{old('api_access_token', $user->api_access_token)}}"></div>
                        </div>
                        <div class="mt-5 text-left"><button  class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
