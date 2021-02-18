@extends('cms::panel.newinc.app')
@section('content')
    <div class="main-content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-content">
                    <div class="card-body">
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.logs.title') }}</div>
                        </div>
                        <div class="card-body">
                            @foreach($logs as $log)
                                @php( $type = explode("\\", $log->loggable_type))
                                @switch($log->crud)
                                    @case("C")
                                    <div class="" data-user="{!! $log->user->name !!}" data-module="{!! $type[2] !!}">
                                        {!!$log->created_at." | ".trans('cms::panel.logs.created',['name' => $log->user->name, 'module' => $type[2], 'id' => $log->loggable_id ]) !!}
                                        @break
                                        @case("U")
                                        <div class="" data-user="{!! $log->user->name !!}" data-module="{!! $type[2] !!}">
                                            {!!$log->created_at." | ".trans('cms::panel.logs.updated',['name' => $log->user->name, 'module' => $type[2], 'id' => $log->loggable_id ]) !!}
                                        @break
                                        @case("D")
                                        <div class="" data-user="{!! $log->user->name !!}" data-module="{!! $type[2] !!}">
                                            {!!$log->created_at." | ".trans('cms::panel.logs.deleted',['name' => $log->user->name, 'module' => $type[2], 'id' => $log->loggable_id ]) !!}
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
