@extends('cms::panel.newinc.app')
@push('css')

@endpush

@push('js')
@endpush
@section('content')

    <div class="main-content container-fluid">
        <div class="page-title">
            <h3>{{ trans('cms::panel.redirects_title') }}</h3>
            <p class="text-subtitle text-muted">{{ trans('cms::panel.redirects_subtitle') }}</p>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-content">
                    <div class="card-body">
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.redirects_create') }}</div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form method="POST" action="{!! route('redirects.store') !!}" class="form-control-lg">
                                    @method('POST')
                                    @csrf
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.redirects_from') !!}</label>
                                        <input type="text" class="form-control" id="from" name="from"  value="{!! old('from') !!}">
                                        @include('cms::panel.inc.form_error',['input_name' => 'from'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.redirects_to') !!}</label>
                                        <input type="text" class="form-control" id="to" name="to"  value="{!! old('to') !!}">
                                        @include('cms::panel.inc.form_error',['input_name' => 'to'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.redirects_code') !!}</label>
                                        <input type="text" class="form-control" id="code" name="code"  value="{!! old('code') !!}">
                                        @include('cms::panel.inc.form_error',['input_name' => 'code'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.redirects_status') !!}</label>
                                        <div>
                                            <select class="custom-select custom-select-lg form-control" name="status">
                                                <option value="1" >{!! trans('cms::panel.active') !!}</option>
                                                <option value="0" >{!! trans('cms::panel.passive') !!}</option>
                                            </select>
                                        </div>
                                        @include('cms::panel.inc.form_error',['input_name' => 'status'])
                                    </div>
                                    <div class="form-group page-date">
                                        <input type="submit" class="form-control btn-primary col-3" id="submit" value="{!! trans('cms::panel.redirects_save') !!}">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
