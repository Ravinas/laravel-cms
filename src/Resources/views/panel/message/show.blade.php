@extends('cms::panel.newinc.app')
@push('css')

@endpush

@push('js')
@endpush

@section('content')
    <div class="main-content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-content">
                    <div class="card-body">
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.messages.show') }}</div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive"></div>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>{!! trans('cms::panel.messages.input') !!}</th><th>{!! trans('cms::panel.messages.value') !!}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{!! trans('cms::panel.messages.ip') !!}</td><td>{!! $message->ip !!}</td>
                                            </tr>
                                            <tr>
                                                <td>{!! trans('cms::panel.messages.data') !!}</td><td>{!! print_r($message->inputs) !!}</td>
                                            </tr>

{{--                                            @foreach($message->inputs as $k => $v)--}}
{{--                                                @php if($v == "no_input") $v = trans('cms::panel.messages.'.$v) @endphp--}}
{{--                                                @if(strpos($k,"f_")!==false)--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{!! $k !!}</td><td><a href="{!! config("app.url") !!}{!! $v !!}" target="_blank">{!! $v !!}</a> </td>--}}
{{--                                                    </tr>--}}
{{--                                                @else--}}
{{--                                                    <tr>--}}
{{--                                                        <td>{!! $k !!}</td><td>{!! $v !!}</td>--}}
{{--                                                    </tr>--}}
{{--                                                @endif--}}
{{--                                            @endforeach--}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
