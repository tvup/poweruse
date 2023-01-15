@extends("layouts.app")

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header text-center font-weight-bold">
            Hent priselementer for målepunkt
        </div>
        @if($data)
        <pre>{{ json_encode($data, JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE+JSON_PRETTY_PRINT) }}</pre>
            <form name="save-charges-form" id="save-charges-form" method="post" >
                {{ csrf_field() }}
                <button type="submit" class="btn btn-primary" @click="createCharges();">Save to DB</button>
            </form>
        @endif
        <div id="app">
            <charge :auth-user="{{ Auth::check() ? json_encode(Auth::user()) : null }}" />
        </div>
    </div>
</div>

@endsection
