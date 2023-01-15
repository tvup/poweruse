<section>
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="mt-5" width="150" src="https://iconarchive.com/download/i19002/iconshock/vista-general/trash.ico">
                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="row mt-2">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">{{ __('Delete account') }}</h4>
                        </div>
                    </div>
                    <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>
                    <div class="mt-5 text-left">
                        <button  class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccount">{{ __('Delete account') }}</button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="deleteAccount" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" aria-labelledby="deleteAccountLabel">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                                    @csrf
                                    @method('delete')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteAccountLabel">Are you sure your want to delete your account?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="col-md-12"><label class="labels">{{ __('Password') }}</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                                        <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
