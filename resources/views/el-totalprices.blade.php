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
            Hent totalpriser
        </div>
        @if(@isset($data))
            @if(old('outputformat')=='SQL')
                <pre>{{ $data ? $data : '' }}</pre>
            @else
                <pre>{{ $data ? json_encode($data, JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT) : '' }}</pre>
            @endif
        @endif
        <div class="card-body">
            <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{url('getTotalPrices')}}">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="exampleInputEmail1">Outputformat:</label>
                    JSON {{ Form::radio('outputformat', 'JSON' , (old('outputformat') && old('outputformat')=='JSON') ? old('outputformat') : true) }}
                    GRAF {{ Form::radio('outputformat', 'GRAF' , (old('outputformat') && old('outputformat')=='GRAF') ? old('outputformat') : false) }}
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Prisområde:</label>
                    {!! Form::select('area', ['ALL'=>'--ingen valgt (alle)','DK1'=>'DK1','DK2'=>'DK2'], old('area') ? : null, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Netselskab</label><br/>
                    {!! Form::select('netcompany', $companies, old('area') ? : null, ['class' => 'form-control']) !!}
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

@endsection