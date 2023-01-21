@extends("layouts.app")

@section('content')
<div class="container mt-4">
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning">
            {!! session('warning') !!}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {!! session('error') !!}
        </div>
    @endif
    <div class="card">
        <div class="card-header text-center font-weight-bold">
            {{ __('Calculation of energy data') }}
        </div>
        <pre>{{ $data ? json_encode($data, JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT) : '' }}</pre>
        <div class="card-body">
            <form name="get-preliminary-invoice-form" id="get-preliminary-invoice-form" method="post" action="{{url('processdata')}}">
                {{ csrf_field() }}
                Datahub
                <label class="switch">
                    <input name="de" id="de" type="checkbox" {{ old('de')=='on' ? 'checked' : ''}}>
                    <span class="slider round"></span>
                </label>
                Ewii
                @if($refresh_token)
                    <input type="hidden" name="token" id="token" value="{{ $refresh_token }}">
                @else
                    <div class="form-group datahub">
                        <label for="exampleInputEmail1">{{ __('Refresh token') }}</label>
                        <input type="text" name="token" id="token" class="form-control"  value="{{ old('token') ?? (Cookie::get('refresh_token') ?? '') }}">
                    </div>
                @endif
                <div class="form-group ewii">
                    <label for="exampleInputEmail1">{{ __('Email') }}</label>
                    <input type="text" name="ewiiEmail" id="ewiiEmail" class="form-control" value="{{ old('ewiiEmail') }}">
                </div>
                <div class="form-group ewii">
                    <label for="exampleInputEmail1">{{ __('Password') }}</label>
                    <input type="password" name="ewiiPassword" id="ewiiPassword" class="form-control" value="{{ old('ewiiPassword') }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Smart-me?</label>
                    <input name="smart_me" id="smart_me" type="checkbox" {{ !empty(old('smart_me')) ? (old('smart_me') == 'on' ? 'checked' : '') : (Cookie::get('smart_me') ? 'checked' : '')}}>
                </div>
                <div class="form-group smartmedetails">
                    <label for="exampleInputEmail1">Smart-me id:</label>
                    <input name="smartmeid" id="smartmeid" class="form-control" type="text" value="{{ old('smartmeid') ?? (Cookie::get('smartmeid') ?? '') }}">
                </div>
                <div class="form-group smartmedetails">
                    <label for="exampleInputEmail1">{{ __('Smart-me username') }}:</label>
                    <input name="smartmeuser" id="smartmeuser" class="form-control" type="text" value="{{ old('smartmeuser') ?? (Cookie::get('smartmeuser') ?? '')}}">
                </div>
                <div class="form-group smartmedetails">
                    <label for="exampleInputEmail1">{{ __('Smart-me password') }}:</label>
                    <input name="smartmepassword" id="smartmepassword" class="form-control" type="password" value="{{ old('smartmepassword') ?? (Cookie::get('smartmepassword') ?? '')}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">{{ __('Start date') }}</label>
                    <input name="start_date" class="date form-control" type="text" value="{{ old('start_date') ? : \Carbon\Carbon::now()->startOfMonth()->toDateString() }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">{{ __('End date (ex.)') }}</label>
                    <input name="end_date" class="date form-control end_date" type="text" value="{{ old('end_date') ? : \Carbon\Carbon::now()->toDateString() }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">{{ __('Price area') }}:</label>
                    DK1 {{ Form::radio('area', 'DK1' , (old('area') && old('area')=='DK1') ? old('area') : false) }}
                    DK2 {{ Form::radio('area', 'DK2' , (old('area') && old('area')=='DK2') ? old('area') : true) }}
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">{{ __('Subscription price pr. month by balance supplier ex. VAT in DKK.') }}</label>
                    <input type="text" name="subscription" id="subscription" class="form-control" required="" value="{{ old('subscription') ? : 23.20}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">{{ __('Overhead by balance supplier on spot price ex. VAT in DKK.') }}</label>
                    <input type="text" name="overhead" id="overhead" class="form-control" required="" value="{{ old('overhead') ? : 0.015}}">
                </div>


                <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
            </form>
        </div>
    </div>
</div>



@endsection

<script type="module">
    window.onload = function () {
        $('.date').datepicker({
            format: 'yyyy-mm-dd'
        });
    }
</script>


<script type="module">
    window.onload = function () {
        $(function() {
            $( "#smart_me" ).change(function() {
                let isSmartMeSelected = $( "#smart_me").is(':checked');
                updateSmartMeDetailFieldsShow(isSmartMeSelected);
                updateDatePicker(isSmartMeSelected);
            });

            function updateSmartMeDetailFieldsShow($boolean) {
                if($boolean) {
                    $('.smartmedetails').show();
                } else {
                    $('.smartmedetails').hide();
                    $('.smartmedetails').each (function(){
                        $(this).find('input').val('');
                    });

                }

            }
            updateSmartMeDetailFieldsShow({{ !empty(old('smart_me')) ? (old('smart_me') == 'on' ? true : false) : (Cookie::get('smart_me') ? true : false) }});

            $( "#de" ).change(function() {
                updateCredentialsFieldsShow($( "#de").is(':checked'));
            });

            function updateCredentialsFieldsShow($boolean) {
                if($boolean) {
                    $('.ewii').show();
                    $('.datahub').hide();
                } else {
                    $('.datahub').show();
                    $('.ewii').hide();
                }
            }
            updateCredentialsFieldsShow({{ old('de') == 'on' }});

            function updateDatePicker($boolean) {
                const today = new Date();
                let tomorrow = new Date();
                tomorrow.setDate(today.getDate() + 1);
                if($boolean) {
                    $('.end_date').datepicker("setDate", tomorrow);
                } else {
                    $('.end_date').datepicker("setDate", today);
                }

            }

            updateDatePicker({{ !empty(old('smart_me')) ? (old('smart_me') == 'on' ? true : false) : (Cookie::get('smart_me') ? true : false) }});


            $(document).ready(function(){
                $(".alert").slideDown(300).delay(10000).slideUp(300);
            });
        });
    }

</script>
