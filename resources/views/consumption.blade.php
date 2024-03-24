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
        <div class="card-header text-center font-weight-bold">
            Hent forbrug
        </div>
        @if(@isset($data))
            <pre>{{ $data ? json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : '' }}</pre>
        @endif
        <div class="card-body">
            {{ html()->form('POST', url('getConsumption'))->open() }}
            {{ csrf_field() }}

            <div class="form-group">
                <label for="source">{{ __('Source:') }}:</label>
                {{ html()->radio('source', (old('source') === 'DATAHUB' || old('source') === null), 'DATAHUB')->id('DATAHUB') }} DATAHUB
                {{ html()->radio('source', (old('source') === 'EWII'), 'EWII')->id('EWII') }} EWII
                {{ html()->radio('source', (old('source') === 'SMART_ME'), 'SMART_ME')->id('SMART_ME') }} SMART_ME
                <div class="smart_me">Tilføj data fra SMART-ME?
                    {{ html()->checkbox('smart_me', old('smart_me') == 'on')->id('smart_me') }}
                </div>
            </div>

            <div class="form-group datahub">
                <label for="token">{{ __('Refresh token') }}</label>
                {{ html()->text('token')->class('form-control')->value(old('token')) }}
            </div>
            <div class="form-group ewii">
                <label for="ewiiEmail">{{ __('Email') }}</label>
                {{ html()->email('ewiiEmail')->class('form-control')->value(old('ewiiEmail')) }}
            </div>
            <div class="form-group ewii">
                <label for="ewiiPassword">{{ __('Password') }}</label>
                {{ html()->password('ewiiPassword')->class('form-control')->value(old('ewiiPassword')) }}
            </div>
            <div class="form-group smartmedetails">
                <label for="smartmeid">{{ __('Smart-me id:') }}</label>
                {{ html()->text('smartmeid')->class('form-control')->value(old('smartmeid')) }}
            </div>
            <div class="form-group smartmedetails">
                <label for="smartmeuser">{{ __('Smart-me username:') }}</label>
                {{ html()->text('smartmeuser')->class('form-control')->value(old('smartmeuser')) }}
            </div>
            <div class="form-group smartmedetails">
                <label for="smartmepassword">{{ __('Smart-me password:') }}</label>
                {{ html()->password('smartmepassword')->class('form-control')->value(old('smartmepassword')) }}
            </div>

            <div class="form-group">
                <label for="start_date">Start dato</label>
                {{ html()->text('start_date')->class('date form-control start_date')->value(old('start_date') ?: \Carbon\Carbon::now()->startOfMonth()->toDateString()) }}
            </div>
            <div class="form-group">
                <label for="end_date">Slut dato (eks.)</label>
                {{ html()->text('end_date')->class('date form-control end_date')->value(old('end_date') ?: \Carbon\Carbon::now()->toDateString()) }}
            </div>

            {{ html()->button(__('Submit'), 'submit')->class('btn btn-primary mt-2') }}
            {{ html()->form()->close() }}
        </div>
    </div>
</div>

@endsection

@section('javaScript')
                $(".alert").slideDown(300).delay(10000).slideUp(300);
        $(function() {
            $('input[type=radio][name=source]').change(function() {
                let isDatahubOrEwiiSelected = $('input[name=source][value=DATAHUB]').is(":checked") || $('input[name=source][value=EWII]').is(":checked");
                let isDatahubSelected = $('input[name=source][value=DATAHUB]').is(":checked");
                let isEwiiSelected = $('input[name=source][value=EWII]').is(":checked");
                let isSmartMeSelected = $('input[name=source][value=SMART_ME]').is(":checked");
                let addSmartMeIsSelected = $( "#smart_me").is(':checked');
                let smartMeIsInPlay = addSmartMeIsSelected || isSmartMeSelected;
                let whoIsSelected = null;

                if (isDatahubSelected) {
                    whoIsSelected = 'DATAHUB';
                } else if (isEwiiSelected) {
                    whoIsSelected = 'EWII';
                } else if (isSmartMeSelected) {
                    whoIsSelected = 'SMART_ME';
                }

                updateSmartMeCheckBoxShow(isDatahubOrEwiiSelected);
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
            var my_bool2 = $('input[name=source][value=DATAHUB]').is(":checked") || $('input[name=source][value=EWII]').is(":checked");
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
                        $('.ewii').hide();
                        if(isAddSmartMeChecked) {
                            $('.smartmedetails').show();
                        } else {
                            $('.smartmedetails').hide();
                        }
                        break;
                    case 'EWII':
                        $('.ewii').show();
                        $('.datahub').hide();
                        if(isAddSmartMeChecked) {
                            $('.smartmedetails').show();
                        } else {
                            $('.smartmedetails').hide();
                        }
                        break;
                    case 'SMART_ME':
                        $('.smartmedetails').show();
                        $('.ewii').hide();
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
