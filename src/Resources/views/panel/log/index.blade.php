@extends('cms::panel.newinc.app')
@section('content')
    <div class="main-content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-content">
                    <div class="card-body">
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.panel_logs') }}</div>
                        </div>
                        <div class="card-body">
                            @foreach($logs as $log)
                                @php( $type = explode("\\",$log->loggable_type))
                                @switch($log->crud)
                                    @case("C")
                                    <div class="alert alert-success">
                                        {!!$log->created_at." ". $log->user->name ." ". $type[2] . " modülünden " . $log->loggable_id. " numaralı içeriği oluşturdu. " !!}
                                        @break
                                        @case("U")
                                        <div class="alert alert-primary">
                                            {!!$log->created_at." ".  $log->user->name ." ". $type[2] . " modülünden " . $log->loggable_id. " numaralı içeriği güncelledi. " !!}
                                        @break
                                        @case("D")
                                        <div class="alert alert-danger">
                                            {!!$log->created_at." ".  $log->user->name ." ". $type[2] . " modülünden " . $log->loggable_id. " numaralı içeriği sildi. " !!}
                                        @break
                                @endswitch
                                    </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                        {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection
