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
                            <div class="divider-text">{{ trans('cms::panel.redirects.create') }}</div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form method="POST" action="{!! route('redirects.store') !!}" class="form-control-lg">
                                    @method('POST')
                                    @csrf
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.redirects.from') !!}</label>
                                        <input type="text" class="form-control shadow-sm" id="from" name="from"  value="{!! old('from') !!}">
                                        @include('cms::panel.inc.form_error',['input_name' => 'from'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.redirects.to') !!}</label>
                                        <input type="text" class="form-control shadow-sm" id="to" name="to"  value="{!! old('to') !!}">
                                        @include('cms::panel.inc.form_error',['input_name' => 'to'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.redirects.code') !!}</label>
                                        <input type="text" class="form-control shadow-sm" id="code" name="code"  value="{!! old('code') !!}">
                                        @include('cms::panel.inc.form_error',['input_name' => 'code'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.redirects.status') !!}</label>
                                        <div>
                                            <select class="custom-select custom-select-lg form-control shadow-sm" name="status">
                                                <option value="1" >{!! trans('cms::panel.active') !!}</option>
                                                <option value="0" >{!! trans('cms::panel.passive') !!}</option>
                                            </select>
                                        </div>
                                        @include('cms::panel.inc.form_error',['input_name' => 'status'])
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-success" id="submit" value="">
                                        {!! trans('cms::panel.redirects.save') !!}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
