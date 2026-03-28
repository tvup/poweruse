@extends("layouts.app")

@section('content')
<div class="container mt-4">
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {!! session('error') !!}
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div class="card-icon me-3"><i class="fa-solid fa-bolt"></i></div>
                <div>
                    <h2 class="card-title">Hent forbrug</h2>
                    <p class="page-subtitle mb-0">{{ __('Retrieve consumption data from Datahub or Smart-ME') }}</p>
                </div>
            </div>
        </div>
        @if(@isset($data))
        <div class="data-panel">
            <div class="data-panel-header" onclick="this.parentElement.querySelector('.data-panel-body').classList.toggle('d-none')">
                <span class="data-panel-title"><i class="fa-solid fa-table me-2"></i>{{ __('Results') }}</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="data-panel-body">
                <pre>{{ $data ? json_encode($data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : '' }}</pre>
            </div>
        </div>
        @endif
        <div class="card-body">
            <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{url('getConsumption')}}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="source">{{ __('Source:') }}:</label>
                    {{ html()->radio('source', (old('source') === 'DATAHUB' || old('source') === null), 'DATAHUB')->id('DATAHUB') }} DATAHUB
                    {{ html()->radio('source', (old('source') === 'SMART_ME'), 'SMART_ME')->id('SMART_ME') }} SMART_ME
                    <div class="smart_me">Tilføj data fra SMART-ME?
                        <input name="smart_me" id="smart_me" type="checkbox" {{ old('smart_me') == 'on' ? 'checked' : ''}}>
                    </div>
                </div>

                @if($refresh_token)
                    <input type="hidden" name="token" id="token" value="{{ $refresh_token }}">
                @else
                    <div class="form-group datahub">
                        <label for="token">{{ __('Refresh token') }}</label>
                        <input type="text" name="token" id="token" class="form-control"  value="{{ old('token') ?? (Cookie::get('refresh_token') ?? '') }}">
                    </div>
                @endif
                <div class="form-group smartmedetails">
                    <label for="smartmeid">{{ __('Smart-me id:') }}</label>
                    <input name="smartmeid" id="smartmeid" class="form-control" type="text" value="{{ old('smartmeid') ?? (auth()->user()?->smartme_directory_id ?? '') }}">
                </div>
                <div class="form-group smartmedetails">
                    <label for="smartmeuser">{{ __('Smart-me username:') }}</label>
                    <input name="smartmeuser" id="smartmeuser" class="form-control" type="text" value="{{ old('smartmeuser') ?? (auth()->user()?->smartme_username ?? '') }}">
                </div>
                <div class="form-group smartmedetails">
                    <label for="smartmepassword">{{ __('Smart-me password:') }}</label>
                    <input name="smartmepassword" id="smartmepassword" class="form-control" type="password" value="{{ old('smartmepassword') ?? (auth()->user()?->smartme_password ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="start_date">Start dato</label>
                    <input name="start_date" class="date form-control start_date" type="text" value="{{ old('start_date') ? : \Carbon\Carbon::now()->startOfMonth()->toDateString() }}">
                </div>
                <div class="form-group">
                    <label for="end_date">Slut dato (eks.)</label>
                    <input name="end_date" class="date form-control end_date" type="text" value="{{ old('end_date') ? : \Carbon\Carbon::now()->toDateString() }}">
                </div>

                <button type="submit" class="btn btn-primary mt-2">{{ __('Submit') }}</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('javaScript')
                $(".alert").slideDown(300).delay(10000).slideUp(300);
        $(function() {
            $('input[type=radio][name=source]').change(function() {
                let isDatahubSelected = $('input[name=source][value=DATAHUB]').is(":checked");
                let isSmartMeSelected = $('input[name=source][value=SMART_ME]').is(":checked");
                let addSmartMeIsSelected = $( "#smart_me").is(':checked');
                let smartMeIsInPlay = addSmartMeIsSelected || isSmartMeSelected;
                let whoIsSelected = null;

                if (isDatahubSelected) {
                    whoIsSelected = 'DATAHUB';
                } else if (isSmartMeSelected) {
                    whoIsSelected = 'SMART_ME';
                }

                updateSmartMeCheckBoxShow(isDatahubSelected);
                updateCredentialsFieldsShow(whoIsSelected, addSmartMeIsSelected);
                updateDatePicker(smartMeIsInPlay);
            });

            function updateSmartMeCheckBoxShow($boolean) {
                if($boolean) {
                    $('.smart_me').show();
                } else {
                    $('#smart_me').prop('checked', false);
                    $('.smart_me').hide();
                }

            }
            var my_bool2 = $('input[name=source][value=DATAHUB]').is(":checked");
            updateSmartMeCheckBoxShow(my_bool2);

            $( "#smart_me" ).change(function() {
                let addSmartMeIsSelected = $( "#smart_me").is(':checked');
                updateDatePicker(addSmartMeIsSelected);
                if(addSmartMeIsSelected) {
                    $('.smartmedetails').show();
                } else {
                    $('.smartmedetails').hide();
                }
            });


            function updateCredentialsFieldsShow(source, isAddSmartMeChecked) {
                switch(source) {
                    case 'DATAHUB':
                        $('.datahub').show();
                        if(isAddSmartMeChecked) {
                            $('.smartmedetails').show();
                        } else {
                            $('.smartmedetails').hide();
                        }
                        break;
                    case 'SMART_ME':
                        $('.smartmedetails').show();
                        $('.datahub').hide();
                        break;
                }
            }
            let isSmartMeInPlay = {{ (old('smart_me') == 'on' || old('source') == 'SMART_ME') ? 'true' : 'false' }} ;
            updateCredentialsFieldsShow({!! old('source') ? '\''.old('source'). '\'' : '\''. 'DATAHUB'.'\'' !!}, isSmartMeInPlay);


            function updateDatePicker($boolean) {
                const today = new Date();
                let tomorrow = new Date();
                tomorrow.setDate(today.getDate() + 1);
                if ($boolean) {
                    flatpickr('.end_date', {defaultDate: tomorrow});
                } else {
                    flatpickr('.end_date', {defaultDate: today});
                }

            }

            flatpickr('.start_date, .end_date');

            updateDatePicker({{ old('smart_me') == 'on' }});
            flatpickr('.start_date', {defaultDate: "{{ old('start_date') ? : \Carbon\Carbon::now()->startOfMonth()->toDateString() }}"});

            $(document).ready(function(){
                $(".alert").slideDown(300).delay(10000).slideUp(300);
            });
        });

@endsection
