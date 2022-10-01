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
            Beregning af energi-data
        </div>
        <pre>{{ $data ? json_encode($data, JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT) : '' }}</pre>
        <div class="card-body">
            <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{url('processdata')}}">
                {{ csrf_field() }}
                Datahub
                <label class="switch">
                    <input name="de" id="de" type="checkbox" {{ old('de')=='on' ? 'checked' : ''}}>
                    <span class="slider round"></span>
                </label>
                Ewii

                <div class="form-group datahub">
                    <label for="exampleInputEmail1">Refresh token</label>
                    <input type="text" name="token" id="token" class="form-control"  value="{{ old('token') }}">
                </div>
                <div class="form-group ewii">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" name="ewiiemail" id="ewiiEmail" class="form-control" value="{{ old('ewiiemail') }}">
                </div>
                <div class="form-group ewii">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" name="ewiipassword" id="ewiiPassword" class="form-control" value="{{ old('ewiipassword') }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Smart-me?</label>
                    <input name="smart_me" id="smart_me" type="checkbox" {{ old('smart_me') == 'on' ? 'checked' : ''}}>
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
                    <input name="end_date" class="date form-control" type="text" value="{{ old('end_date') ? : \Carbon\Carbon::now()->toDateString() }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Prisområde:</label>
                    DK1 {{ Form::radio('area', 'DK1' , (old('area') && old('area')=='DK1') ? old('area') : false) }}
                    DK2 {{ Form::radio('area', 'DK2' , (old('area') && old('area')=='DK2') ? old('area') : true) }}
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Abonnementspris pr. måned hos elleverandør eks. moms i kr.</label>
                    <input type="text" name="subscription" id="subscription" class="form-control" required="" value="{{ old('subscription') ? : 23.20}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Elleverandørens tillæg til spotprisen eks. moms i kr.</label>
                    <input type="text" name="overhead" id="overhead" class="form-control" required="" value="{{ old('overhead') ? : 0.015}}">
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
        $( "#smart_me" ).change(function() {
            updateSmartMeDetailFieldsShow($( "#smart_me").is(':checked'));
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
        updateSmartMeDetailFieldsShow({{ old('smart_me') == 'on' }});

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


        $(document).ready(function(){
            $(".alert").slideDown(300).delay(10000).slideUp(300);
        });
    });
</script>


@endsection