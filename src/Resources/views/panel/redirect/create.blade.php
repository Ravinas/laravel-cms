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
                            <form method="POST" action="{!! route('redirects.store') !!}">
                                @method('POST')
                                @csrf
                                <div class="form-group">
                                    <label>{!! trans('cms::redirect.from') !!}</label>
                                    <input type="text" class="form-control" id="from" name="from" placeholder="{!! trans('cms::redirect.from') !!}" value="{!! old('from') !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'from'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::redirect.to') !!}</label>
                                    <input type="text" class="form-control" id="to" name="to" placeholder="{!! trans('cms::redirect.to') !!}" value="{!! old('to') !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'to'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::redirect.code') !!}</label>
                                    <input type="text" class="form-control" id="code" name="code" placeholder="{!! trans('cms::redirect.code') !!}" value="{!! old('code') !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'code'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::redirect.status') !!}</label>
                                    <div>
                                        <select class="custom-select custom-select-lg mb-3" name="status">
                                            <option value="1">{!! trans('cms::redirect.active') !!}</option>
                                            <option value="0">{!! trans('cms::redirect.passive') !!}</option>
                                        </select>
                                    </div>
                                    @include('cms::panel.inc.form_error',['input_name' => 'status'])
                                </div>
                                <div class="form-group page-date">
                                    <input type="submit" class="form-control btn-primary col-3" id="submit" value="{!! trans('cms::redirect.create') !!}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
