<section>
    <form method="post" action="{{ route('password.update') }}" >
        @csrf
        @method('put')
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150" src="https://plumbr.io/app/uploads/2015/01/thread-lock.jpeg">
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="row mt-2">
                            @if (session('status') === 'password-updated')
                                <div class="alert alert-success" role="alert">
                                    {{ __('Password updated') }}
                                </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-right"> {{ __('Change password') }}</h4>
                            </div>
                            <div class="col-md-12"><label class="labels">{{ __('Current password') }}</label><input type="password" class="form-control" name="current_password" autocomplete="current-password"></div>
                            <div class="col-md-12"><label class="labels">{{ __('New password') }}</label><input type="password" class="form-control" name="password"></div>
                            <div class="col-md-12"><label class="labels">{{ __('Confirm password') }}</label><input type="password" class="form-control" name="password_confirmation"></div>
                        </div>
                        <div class="mt-5 text-left"><button  class="btn btn-primary">{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
