<div class="fade box" id="pwaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <h5 class="modal-title" id="exampleModalLabel">
                {{ __('Install PowerUse as an app - it provides the best experience.') }}
                <br><br>{{ __('How to:') }}
            </h5>
            <div class="step">
                <div>1</div>
                {{ __('Click at the menu icon of your browser above.') }}
            </div>
            <div class="step">
                <div>2</div>
                {{ __('Choose "Install app" in the menu.') }}
            </div>
            <div class="step">
                <div>3</div>
                {{ __('Close this tab and start the app from your home screen') }}
            </div>
            <br/>
            <div>
                <button class="btn btn-secondary"
                        onclick="function closePwaModal() {
                            $('#pwaModal').fadeOut().promise().done(function() {
                                $('#pwaModal').css('z-index', -1);
                                $('.modal-backdrop').fadeOut().promise().done(function() {
                                    $('.modal-backdrop').hide();
                                });
                            });
                            $('body').removeClass('modal-open');
                            $('body').removeAttr( 'style' );
                            $('.arrow').removeAttr('style');
                            $('.arrow').css('display','none');
                        } closePwaModal();">
                    {{ __('No, thank you') }}
                </button>
            </div>
        </div>
    </div>
</div>
<div class="arrow" style="display: none;"></div>