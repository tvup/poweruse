<section>
    <form method="post" action="{{ route('smartme.update') }}" >
        @csrf
        @method('patch')
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150" src="{{ Vite::asset('resources/images/img.png')}}">
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="row mt-2">
                            @if (session('status') === 'smartme-updated')
                                <div class="alert alert-success" role="alert">
                                    {{ __('Smart-me credentials updated') }}
                                </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right"> {{ __('Smart-me') }}</h4>
                            </div>
                            <div class="col-md-12"><label class="labels">{{ __('Username') }}</label><input type="text" class="form-control" name="username" value="{{old('username', $user->smartme_username)}}"></div>
                            <div class="col-md-12"><label class="labels">{{ __('Password') }}</label><input type="text" class="form-control" name="password" value="{{old('password', $user->smartme_password)}}"></div>
                            <div class="col-md-12"><label class="labels">{{ __('Directory id') }}</label><input type="text" class="form-control" name="directory_id" value="{{old('directory_id', $user->smartme_directory_id)}}"></div>
                        </div>
                        <div class="mt-5 text-left"><button  class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
