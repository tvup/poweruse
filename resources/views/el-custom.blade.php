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
            Beregning af et bestemt forbrug i dag
        </div>
        <pre>{{ $data ? json_encode($data, JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT) : '' }}</pre>
        <div class="card-body">
            <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{url('processcustom')}}">
                {{ csrf_field() }}
                @if($refresh_token)
                    <input type="hidden" name="token" id="token" value="{{ $refresh_token }}">
                @else
                    <div class="form-group datahub">
                        <label for="token">{{ __('Refresh token') }}</label>
                        <input type="text" name="token" id="token" class="form-control"  value="{{ old('token') ?? (Cookie::get('refresh_token') ?? '') }}">
                    </div>
                @endif

                @for ($i = 0; $i < 24; $i++)
                    <div class="form-group datahub">
                        <label for="exampleInputEmail1">{{ ($i) . '-' .  ($i+1) }}</label>
                        <input type="text" name="usage{{$i}}" id="usage{{$i}}" class="form-control"  value="{{ old('usage'.$i) }}">
                    </div>
                @endfor

                <div class="form-group">
                    <label for="area">Prisområde:</label>
                    {{ html()->radio('area', (old('area') === 'DK1' || old('area') === null), 'DK1')->id('DK1') }} DK1
                    {{ html()->radio('area', old('area') === 'DK2', 'DK2')->id('DK2') }} DK2
                </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Elleverandørens tillæg til spotprisen eks. moms i kr.</label>
                    <input type="text" name="overhead" id="overhead" class="form-control" required="" value="{{ old('overhead') ? : 0.015}}">
                </div>


                <button type="submit" class="btn btn-primary mt-2">{{ __('Submit') }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
