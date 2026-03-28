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
        <div class="card-header">
            <div class="d-flex align-items-center">
                <div class="card-icon me-3"><i class="fa-solid fa-calculator"></i></div>
                <div>
                    <h2 class="card-title">{{ __('Calculation of energy data') }}</h2>
                    <p class="page-subtitle mb-0">{{ __('Calculate your electricity bill based on actual usage') }}</p>
                </div>
            </div>
        </div>
        @if($data)
        <div class="data-panel">
            <div class="data-panel-header" onclick="this.parentElement.querySelector('.data-panel-body').classList.toggle('d-none')">
                <span class="data-panel-title"><i class="fa-solid fa-table me-2"></i>{{ __('Results') }}</span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
            <div class="data-panel-body">
                <pre>{{ json_encode($data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
        @endif
        <div class="card-body">
            <form name="get-preliminary-invoice-form" id="get-preliminary-invoice-form" method="post" action="{{url('processdata')}}">
                {{ csrf_field() }}
                @if($refresh_token)
                    <input type="hidden" name="token" id="token" value="{{ $refresh_token }}">
                @else
                    <div class="form-group datahub">
                        <label for="token">{{ __('Refresh token') }}</label>
                        <input type="text" name="token" id="token" class="form-control"  value="{{ old('token') ?? (Cookie::get('refresh_token') ?? '') }}">
                    </div>
                @endif
                <div class="form-group">
                    <label for="smart_me">Smart-me?</label>
                    <input name="smart_me" id="smart_me" type="checkbox" {{ old('_token') ? (old('smart_me') == 'on' ? 'checked' : '') : (Cookie::get('smart_me') ? 'checked' : (auth()->user()?->smartme_directory_id ? 'checked' : ''))}}>
                </div>
                <div class="form-group smartmedetails">
                    <label for="smartmeid">Smart-me id:</label>
                    <input name="smartmeid" id="smartmeid" class="form-control" type="text" value="{{ old('smartmeid') ?: (Cookie::get('smartmeid') ?: (auth()->user()?->smartme_directory_id ?? '')) }}">
                </div>
                <div class="form-group smartmedetails">
                    <label for="smartmeuser">{{ __('Smart-me username') }}:</label>
                    <input name="smartmeuser" id="smartmeuser" class="form-control" type="text" value="{{ old('smartmeuser') ?: (Cookie::get('smartmeuser') ?: (auth()->user()?->smartme_username ?? ''))}}">
                </div>
                <div class="form-group smartmedetails">
                    <label for="smartmepassword">{{ __('Smart-me password') }}:</label>
                    <input name="smartmepassword" id="smartmepassword" class="form-control" type="password" value="{{ old('smartmepassword') ?: (Cookie::get('smartmepassword') ?: (auth()->user()?->smartme_password ?? ''))}}">
                </div>
                <div class="form-group">
                    <label for="start_date">{{ __('Start date') }}</label>
                    <input name="start_date" class="date form-control start_date" type="text" value="{{ old('start_date') ? : \Carbon\Carbon::now()->startOfMonth()->toDateString() }}">
                </div>
                <div class="form-group">
                    <label for="end_date">{{ __('End date (ex.)') }}</label>
                    <input name="end_date" class="date form-control end_date" type="text" value="{{ old('end_date') ? : \Carbon\Carbon::now()->toDateString() }}">
                </div>
                <div class="form-group">
                    {!! html()->label(__('Price area')) !!}
                    @php $selectedArea = old('area') ?: Cookie::get('area') ?: 'DK1'; @endphp
                    {!! html()->radio('area', 'DK1')->checked($selectedArea == 'DK1')->value('DK1') !!} DK1
                    {!! html()->radio('area', 'DK2')->checked($selectedArea == 'DK2')->value('DK2') !!} DK2
                </div>

                <div class="form-group">
                    <label for="subscription">{{ __('Subscription price pr. month by balance supplier ex. VAT in DKK.') }}</label>
                    <input type="text" name="subscription" id="subscription" class="form-control" required="" value="{{ old('subscription') ?: (Cookie::get('subscription') ?: 23.20) }}">
                </div>
                <div class="form-group">
                    <label for="overhead">{{ __('Overhead by balance supplier on spot price ex. VAT in DKK.') }}</label>
                    <input type="text" name="overhead" id="overhead" class="form-control" required="" value="{{ old('overhead') ?: (Cookie::get('overhead') ?: 0.048) }}">
                </div>


                <div class="mt-3">
                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true" id="submit-spinner"></span>
                        <span id="submit-text">{{ __('Submit') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@section('javaScript')
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
                }

            }
            updateSmartMeDetailFieldsShow({{ old('_token') ? (old('smart_me') == 'on' ? 'true' : 'false') : (Cookie::get('smart_me') ? 'true' : (auth()->user()?->smartme_directory_id ? 'true' : 'false')) }});

            function updateDatePicker($boolean) {
                const existingValue = document.querySelector('.end_date').value;
                if (existingValue) {
                    flatpickr('.end_date', {defaultDate: existingValue});
                    return;
                }
                const today = new Date();
                let tomorrow = new Date();
                tomorrow.setDate(today.getDate() + 1);
                if ($boolean) {
                    flatpickr('.end_date', {defaultDate: tomorrow});
                } else {
                    flatpickr('.end_date', {defaultDate: today});
                }
            }

            flatpickr('.start_date, .end_date', {});

            updateDatePicker({{ old('_token') ? (old('smart_me') == 'on' ? true : false) : (Cookie::get('smart_me') ? true : false) }});


            $('#get-preliminary-invoice-form').on('submit', function() {
                $('#submit-spinner').removeClass('d-none');
                $('#submit-icon').addClass('d-none');
                $('#submit-text').text('{{ __('Processing') }}...');
                $('#submit-btn').prop('disabled', true);
            });

            $(document).ready(function(){
                $(".alert").slideDown(300).delay(10000).slideUp(300);
            });
        });

@endsection
