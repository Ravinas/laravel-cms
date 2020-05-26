@if(session('form_errors'))
    <div class="card">
        <div class="alert-danger" role="alert">
            <div class="card-block">
                @foreach(session('form_errors') as $error)
                    @foreach($error as $e)
                        <h2 class="card-title">{!! $e !!}</h2>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endif
