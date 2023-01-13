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
            Hent data om målepunkt
        </div>
        <pre>{{ $data ? json_encode($data, JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT) : '' }}</pre>
        <div class="card-body">
            <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{url('getMeteringPointData')}}">
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
                    <input type="text" name="ewiiemail" id="ewiiemail" class="form-control" value="{{ old('ewiiemail') }}">
                </div>
                <div class="form-group ewii">
                    <label for="exampleInputEmail1">Password</label>
                    <input type="password" name="ewiipassword" id="ewiipassword" class="form-control" value="{{ old('ewiipassword') }}">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<script>
    $(function() {
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
