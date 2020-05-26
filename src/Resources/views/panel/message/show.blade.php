@extends('cms::panel.inc.app')
@push('css')

@endpush

@push('js')

@endpush

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            @include('cms::panel.inc.breadcrumb')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <h2 class="card-title">{!! $message->form_name !!} {!! trans('cms::form.message') !!} #{!! $message->id !!}</h2>
                            <div class="table-responsive"></div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{!! trans('cms::form.input') !!}</th><th>{!! trans('cms::form.value') !!}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{!! trans('cms::form.ip') !!}</td><td>{!! $message->ip !!}</td>
                                        </tr>
                                    @foreach($message->inputs as $k => $v)
                                        @php if($v == "no_input") $v = trans('cms::panel.'.$v) @endphp
                                        @if(strpos($k,"f_")!==false)
                                        <tr>
                                            <td>{!! $k !!}</td><td><a href="{!! env("APP_URL") !!}{!! $v !!}" target="_blank">{!! $v !!}</a> </td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td>{!! $k !!}</td><td>{!! $v !!}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
