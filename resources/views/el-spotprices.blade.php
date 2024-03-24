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
            Hent spotpriser
        </div>
        @if(@isset($data))
            @if(old('outputformat')=='SQL')
                <pre>{{ $data ? $data : '' }}</pre>
            @else
                <pre>{{ $data ? json_encode($data, JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT) : '' }}</pre>
            @endif
        @endif
        <div class="card-body">
            <form name="get-spot-prices-form" id="get-spot-prices-form" method="post" action="{{url('getSpotprices')}}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="outputformat">Outputformat:</label>
                    {{ html()->radio('outputformat', (old('outputformat') === 'JSON'), 'JSON')->checked(true) }} JSON
                    {{ html()->radio('outputformat', (old('outputformat') === 'SQL'), 'SQL') }} SQL
                    {{ html()->radio('outputformat', (old('outputformat') === 'POWERUSE'), 'POWERUSE') }} POWERUSE
                </div>

                <div class="form-group">
                    <label for="start_date">Start dato</label>
                    <input name="start_date" class="date form-control start_date" type="text" value="{{ old('start_date') ? : \Carbon\Carbon::now()->startOfMonth()->toDateString() }}">
                </div>
                <div class="form-group">
                    <label for="end_date">Slut dato (eks.)</label>
                    <input name="end_date" class="date form-control end_date" type="text" value="{{ old('end_date') ? : \Carbon\Carbon::now()->toDateString() }}">
                </div>

                <div class="form-group">
                    <label for="area">Prisområde:</label>
                    {{ html()->select('area', ['ALL'=>'--ingen valgt (alle)','DK1'=>'DK1','DK2'=>'DK2'], old('area'))->class('form-control') }}
                </div>

                <div class="form-group">
                    <label for="columns">Vis kolonner:</label><br/>
                    HourUTC: {{ html()->checkbox('CheckboxHourUTC', old('CheckboxHourUTC'))->value(1) }}<br/>
                    HourDK: {{ html()->checkbox('CheckboxHourDK', old('CheckboxHourDK') ?: true)->value(1) }}<br/>
                    PriceArea: {{ html()->checkbox('CheckboxPriceArea', old('CheckboxPriceArea'))->value(1) }}<br/>
                    SpotPriceDKK: {{ html()->checkbox('CheckboxSpotPriceDKK', old('CheckboxSpotPriceDKK') ?: true)->value(1) }}<br/>
                    SpotPriceEUR: {{ html()->checkbox('CheckboxSpotPriceEUR', old('CheckboxSpotPriceEUR'))->value(1) }}
                </div>


                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('javaScript')
        flatpickr('.start_date, .end_date');

        $(function() {
            $(document).ready(function(){
                $(".alert").slideDown(300).delay(10000).slideUp(300);
            });
        });
@endsection