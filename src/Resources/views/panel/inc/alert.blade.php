@if(session('type') && session('message'))
    <div class="card">
        <div class="alert-{!! session('type') !!}" role="alert">
            <div class="card-block">
            <h2 class="card-title">{!! trans(session('message')) !!}</h2>
            </div>
        </div>
    </div>
@endif
