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
                            <div class="divider-text">{{ trans('cms::panel.redirects.edit') }}</div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form method="POST" action="{!! route('redirects.update',['redirect' => $redirect]) !!}" class="form-control-lg">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.redirects.from') !!}</label>
                                        <input type="text" class="form-control shadow-sm" id="from" name="from"  value="{!! old('from') ?? $redirect->from !!}">
                                        @include('cms::panel.inc.form_error',['input_name' => 'from'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.redirects.to') !!}</label>
                                        <input type="text" class="form-control shadow-sm" id="to" name="to"  value="{!! old('to') ?? $redirect->to !!}">
                                        @include('cms::panel.inc.form_error',['input_name' => 'to'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.redirects.code') !!}</label>
                                        <input type="text" class="form-control shadow-sm" id="code" name="code"  value="{!! old('code') ?? $redirect->code !!}">
                                        @include('cms::panel.inc.form_error',['input_name' => 'code'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.redirects.status') !!}</label>
                                        <div>
                                            <select class="custom-select custom-select-lg form-control shadow-sm" name="status">
                                                <option value="1" @if($redirect->status == 1) selected @endif>{!! trans('cms::panel.active') !!}</option>
                                                <option value="0" @if($redirect->status == 0) selected @endif>{!! trans('cms::panel.passive') !!}</option>
                                            </select>
                                        </div>
                                        @include('cms::panel.inc.form_error',['input_name' => 'status'])
                                    </div>
                                    <div class="form-group page-date">
                                        <input type="submit" class="form-control btn-primary shadow-sm" id="submit" value="{!! trans('cms::panel.redirects.save') !!}">
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

@section('mert')
    <div class="page-wrapper">
        <div class="container-fluid">
            @include('cms::panel.inc.breadcrumb')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <form method="POST" action="{!! route('redirects.update',['redirect' => $redirect]) !!}">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label>{!! trans('cms::redirect.from') !!}</label>
                                    <input type="text" class="form-control" id="from" name="from" placeholder="{!! trans('cms::redirect.from') !!}" value="{!! old('from') ?? $redirect->from !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'from'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::redirect.to') !!}</label>
                                    <input type="text" class="form-control" id="to" name="to" placeholder="{!! trans('cms::redirect.to') !!}" value="{!! old('to') ?? $redirect->to !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'to'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::redirect.code') !!}</label>
                                    <input type="text" class="form-control" id="code" name="code" placeholder="{!! trans('cms::redirect.code') !!}" value="{!! old('code') ?? $redirect->code !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'code'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::redirect.status') !!}</label>
                                    <div>
                                        <select class="custom-select custom-select-lg mb-3" name="status">
                                            <option value="1" @if($redirect->status == 1) selected @endif>{!! trans('cms::redirect.active') !!}</option>
                                            <option value="0" @if($redirect->status == 0) selected @endif>{!! trans('cms::redirect.passive') !!}</option>
                                        </select>
                                    </div>
                                    @include('cms::panel.inc.form_error',['input_name' => 'status'])
                                </div>
                                <div class="form-group page-date">
                                    <input type="submit" class="form-control btn-primary col-3" id="submit" value="{!! trans('cms::redirect.edit') !!}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
