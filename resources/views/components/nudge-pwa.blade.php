<div class="fade box" id="pwaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <h5 class="modal-title" id="exampleModalLabel">
                Installer PowerUse som en app, det giver den bedste brugeroplevelse.<br><br>Sådan gør du:
            </h5>
            <div class="step">
                <div>1</div>
                Klik på din browsers menu ikon herover.
            </div>
            <div class="step">
                <div>2</div>
                I menuen, vælg "Føj til startskærm".
            </div>
            <div class="step">
                <div>3</div>
                Luk denne fane og start applikationen fra din startskærm
            </div>
            <br/>
            <div>
                <button class="btn btn-secondary"
                        onclick="function closePwaModal() {
                            $('#pwaModal').fadeOut().promise().done(function() {
                                $('.modal-backdrop').fadeOut().promise().done(function() {
                                    $('.modal-backdrop').remove();
                                });
                            });
                            $('body').removeClass('modal-open');
                            $('body').removeAttr( 'style' );
                            $('.arrow').removeAttr('style');
                            $('.arrow').css('display','none');
                        } closePwaModal();">
                    Nej tak
                </button>
            </div>
        </div>
    </div>
</div>
<div class="arrow" style="display: none;"></div>