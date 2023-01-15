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
            Hent priselementer for målepunkt
        </div>
        <pre>{{ $data ? json_encode($data, JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT) : '' }}</pre>
        <div class="card-body">
            <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{url('getChargesForWeb')}}">
                {{ csrf_field() }}

                <div class="form-group datahub">
                    <label for="exampleInputEmail1">Refresh token</label>
                    <input type="text" name="token" id="token" class="form-control"  value="{{ old('token') }}">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection

<script type="module">
    window.onload = function () {
        $(function() {
            $(document).ready(function(){
                $(".alert").slideDown(300).delay(10000).slideUp(300);
            });
        });
    }

</script>