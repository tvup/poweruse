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
                    <label for="exampleInputEmail1">Source:</label>
                    DATAHUB {{ Form::radio('source', 'DATAHUB' , (old('source') && old('source')=='DATAHUB') ? old('source') : true) }}
                    EWII {{ Form::radio('source', 'EWII' , (old('source') && old('source')=='EWII') ? old('source') : false) }}
                    SMART-ME {{ Form::radio('source', 'SMART-ME' , (old('source') && old('source')=='SMART-ME') ? old('source') : false) }}
                    <div class="smart_me">Tilføj data fra SMART-ME?
                        <input name="smart_me" id="smart_me" type="checkbox" {{ old('smart_me') == 'on' ? 'checked' : ''}}>
                    </div>
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
            var is_datahub_or_ewii_selected = $('input[name=source][value=DATAHUB]').is(":checked") || $('input[name=source][value=EWII]').is(":checked");
            var is_smartme_selected = $('input[name=source][value=SMART-ME]').is(":checked");
            updateSmartMeCheckBoxShow(is_datahub_or_ewii_selected);
            updateDatePicker(is_smartme_selected);
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
            updateDatePicker($( "#smart_me").is(':checked'));
        });

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