<div class="container rounded mt-5 mb-5">
@isset($errors)
    @foreach($errors->getBags() as $errorBag)
        <ul class="list-group">
            @foreach($errorBag->all() as $error)
                <li class="fw-bold list-group-item list-group-item-danger">❌ {{ $error }}</li>
            @endforeach
        </ul>
    @endforeach
@endisset
</div>
