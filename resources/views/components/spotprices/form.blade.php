<form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{url('getSpotprices')}}">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="exampleInputEmail1">Outputformat:</label>
        JSON {{ Form::radio('outputformat', 'JSON' , (old('outputformat') && old('outputformat')=='JSON') ? old('outputformat') : true) }}
        SQL {{ Form::radio('outputformat', 'SQL' , (old('outputformat') && old('outputformat')=='SQL') ? old('outputformat') : false) }}
        POWERUSE {{ Form::radio('outputformat', 'POWERUSE' , (old('outputformat') && old('outputformat')=='POWERUSE') ? old('outputformat') : false) }}
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
        {!! Form::select('area', ['ALL'=>'--ingen valgt (alle)','DK1'=>'DK1','DK2'=>'DK2'], old('area') ? : null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        <label for="exampleInputEmail1">Vis kolonner:</label><br/>
        HourUTC: {!! Form::checkbox('CheckboxHourUTC', 1, old('CheckboxHourUTC') ? : false); !!}<br/>
        HourDK: {!! Form::checkbox('CheckboxHourDK', 1, old('CheckboxHourDK') ? : true); !!}<br/>
        PriceArea: {!! Form::checkbox('CheckboxPriceArea', 1, old('CheckboxPriceArea') ? : false); !!}<br/>
        SpotPriceDKK: {!! Form::checkbox('CheckboxSpotPriceDKK', 1, old('CheckboxSpotPriceDKK') ? : true); !!}<br/>
        SpotPriceEUR: {!! Form::checkbox('CheckboxSpotPriceEUR', 1, old('CheckboxSpotPriceEUR') ? : false); !!}
    </div>


    <button type="submit" class="btn btn-primary">Submit</button>
</form>