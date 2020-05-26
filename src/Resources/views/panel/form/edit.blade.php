@extends('cms::panel.inc.app')
@push('css')

@endpush

@push('js')

@endpush

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            @include('cms::panel.inc.breadcrumb')
            @include('cms::panel.inc.form_errors')
            @include('cms::panel.inc.alert')
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-block">
                            <form method="POST" action="{!! route('forms.update',array('form'=>$form)) !!}" class="form-horizontal form-material">
                                @method('PUT')
                                @csrf
                                <div class="form-text"><h1>{!! $form->name !!}</h1></div>
                                <div class="form-group page-order">
                                    <label>{!! trans('cms::form.name') !!}</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="{!! trans('cms::form.name') !!}"
                                           value="{!! old('name') ?? $form->name !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'name'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::form.email') !!}</label>
                                    <input type="text" class="form-control form-control-line" id="email" name="email"
                                           placeholder="{!! trans('cms::form.email') !!}"
                                           value="{!! old('email') ?? $form->email !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'email'])
                                </div>
                                <div class="form-group page-date">
                                    <label>{!! trans('cms::form.slug') !!}</label>
                                    <input type="text" class="form-control" id="slug" name="slug"
                                           placeholder="{!! trans('cms::form.slug') !!}"
                                           value="{!! old('slug') ?? $form->slug !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'slug'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::form.rules') !!}</label>
                                    <textarea class="form-control" name="rules">{!! old('rules') ?? $form->rules !!}</textarea>
                                    @include('cms::panel.inc.form_error',['input_name' => 'rules'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::form.error_messages') !!}</label>
                                    <textarea class="form-control" name="error_messages">{!! old('error_messages') ?? $form->error_messages !!}</textarea>
                                    @include('cms::panel.inc.form_error',['input_name' => 'error_messages'])
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success" id="submit" value="">
                                        {!! trans('cms::panel.save') !!}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
