@extends("layout")

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
            <pre>{{ $data ? json_encode($data, JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT) : '' }}</pre>
        @endif
        <div class="card-body">
            <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{url('getConsumption')}}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="exampleInputEmail1">Kilde:</label>
                    DATAHUB {{ Form::radio('source', 'DATAHUB' , (old('source') && old('source')=='DATAHUB') ? old('source') : true) }}
                    EWII {{ Form::radio('source', 'EWII' , (old('source') && old('source')=='EWII') ? old('source') : false) }}
                    SMART-ME {{ Form::radio('source', 'SMART-ME' , (old('source') && old('source')=='SMART-ME') ? old('source') : false) }}
                    <div class="smart_me">Tilføj data fra SMART-ME?
                        <input name="smart_me" id="smart_me" type="checkbox" {{ old('smart_me') == 'on' ? 'checked' : ''}}>
                    </div>
                </div>

                <div class="form-group datahub">
                    <label for="exampleInputEmail1">Refresh token</label>
                    <input type="text" name="token" id="token" class="form-control"  value="{{ old('token') }}">
                </div>
                <div class="form-group ewii">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" name="ewiiEmail" id="ewiiEmail" class="form-control" value="{{ old('ewiiEmail') }}">
                </div>
                <div class="form-group ewii">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" name="ewiiPassword" id="ewiiPassword" class="form-control" value="{{ old('ewiiPassword') }}">
                </div>
                <div class="form-group smartmedetails">
                    <label for="exampleInputEmail1">Smart-me id:</label>
                    <input name="smartmeid" id="smartmeid" class="form-control" type="text" value="{{ old('smartmeid') }}">
                </div>
                <div class="form-group smartmedetails">
                    <label for="exampleInputEmail1">Smart-me username:</label>
                    <input name="smartmeuser" id="smartmeuser" class="form-control" type="text" value="{{ old('smartmeuser') }}">
                </div>
                <div class="form-group smartmedetails">
                    <label for="exampleInputEmail1">Smart-me password:</label>
                    <input name="smartmepassword" id="smartmepassword" class="form-control" type="password" value="{{ old('smartmepassword') }}">
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Start dato</label>
                    <input name="start_date" class="date form-control" type="text" value="{{ old('start_date') ? : \Carbon\Carbon::now()->startOfMonth()->toDateString() }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Slut dato (eks.)</label>
                    <input name="end_date" class="date form-control end_date" type="text" value="{{ old('end_date') ? : \Carbon\Carbon::now()->toDateString() }}">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.date').datepicker({
        format: 'yyyy-mm-dd'
    });

</script>

<script>
    $(function() {
        $(document).ready(function(){
            $(".alert").slideDown(300).delay(10000).slideUp(300);
        });
    });
</script>

<script>
    $(function() {
        $('input[type=radio][name=source]').change(function() {
            let isDatahubOrEwiiSelected = $('input[name=source][value=DATAHUB]').is(":checked") || $('input[name=source][value=EWII]').is(":checked");
            let isDatahubSelected = $('input[name=source][value=DATAHUB]').is(":checked");
            let isEwiiSelected = $('input[name=source][value=EWII]').is(":checked");
            let isSmartMeSelected = $('input[name=source][value=SMART-ME]').is(":checked");
            let addSmartMeIsSelected = $( "#smart_me").is(':checked');
            let smartMeIsInPlay = addSmartMeIsSelected || isSmartMeSelected;
            let whoIsSelected = null;

            if (isDatahubSelected) {
                whoIsSelected = 'DATAHUB'
            } else if (isEwiiSelected) {
                whoIsSelected = 'EWII'
            } else if (isSmartMeSelected) {
                whoIsSelected = 'SMART-ME'
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
                case 'SMART-ME':
                    $('.smartmedetails').show();
                    $('.ewii').hide();
                    $('.datahub').hide();
                    break;
            }
        }
        let isSmartMeInPlay = {{ (old('smart_me') == 'on' || old('source') == 'SMART-ME') ? 'true' : 'false' }} ;
        updateCredentialsFieldsShow({!! old('source') ? '\''.old('source'). '\'' : '\''. 'DATAHUB'.'\'' !!}, isSmartMeInPlay);


        function updateDatePicker($boolean) {
            const today = new Date()
            let tomorrow = new Date()
            tomorrow.setDate(today.getDate() + 1)
            if($boolean) {
                $('.end_date').datepicker("setDate", tomorrow);
            } else {
                $('.end_date').datepicker("setDate", today);
            }

        }
        updateDatePicker({{ old('smart_me') == 'on' }});

        $(document).ready(function(){
            $(".alert").slideDown(300).delay(10000).slideUp(300);
        });
    });
</script>

@endsection