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
                            <form method="POST" action="{!! route('forms.store') !!}">
                                @method('POST')
                                @csrf
                                <div class="form-group">
                                    <label>{!! trans('cms::form.name') !!}</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="{!! trans('cms::form.name') !!}" value="{!! old('name') !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'name'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::form.email') !!}</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="{!! trans('cms::form.email') !!}" value="{!! old('email') !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'email'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::form.slug') !!}</label>
                                    <input type="text" class="form-control" id="slug" name="slug" placeholder="{!! trans('cms::form.slug') !!}" value="{!! old('slug') !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'slug'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::form.rules') !!}</label>
                                    <textarea class="form-control" name="rules">{!! old('rules') !!}</textarea>
                                    @include('cms::panel.inc.form_error',['input_name' => 'rules'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::form.error_messages') !!}</label>
                                    <textarea class="form-control" name="error_messages">{!! old('error_messages') !!}</textarea>
                                    @include('cms::panel.inc.form_error',['input_name' => 'error_messages'])
                                </div>
                                <div class="form-group page-date">
                                    <input type="submit" class="form-control btn-primary col-3" id="submit" value="{!! trans('cms::form.create') !!}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
