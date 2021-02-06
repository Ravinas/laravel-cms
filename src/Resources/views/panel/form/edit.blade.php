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
                            <div class="divider-text">{{ trans('cms::panel.forms.edit') }}</div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form method="POST" action="{!! route('forms.update',array('form'=>$form)) !!}" class="form-horizontal form-material">
                                    @method('PUT')
                                    @csrf
                                    <div class="form-text"><h1>{!! $form->name !!}</h1></div>
                                    <div class="form-group page-order">
                                        <label>{!! trans('cms::panel.forms.name') !!}</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               value="{!! old('name') ?? $form->name !!}">
                                        @include('cms::panel.inc.form_error',['input_name' => 'name'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.forms.email') !!}</label>
                                        <input type="text" class="form-control form-control-line" id="email" name="email"
                                               value="{!! old('email') ?? $form->email !!}">
                                        @include('cms::panel.inc.form_error',['input_name' => 'email'])
                                    </div>
                                    <div class="form-group page-date">
                                        <label>{!! trans('cms::panel.forms.slug') !!}</label>
                                        <input type="text" class="form-control" id="slug" name="slug"
                                               value="{!! old('slug') ?? $form->slug !!}">
                                        @include('cms::panel.inc.form_error',['input_name' => 'slug'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.forms.rules') !!}</label>
                                        <textarea class="form-control" name="rules" rows="4">{!! old('rules') ?? $form->rules !!}</textarea>
                                        @include('cms::panel.inc.form_error',['input_name' => 'rules'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.forms.error_messages') !!}</label>
                                        <textarea class="form-control" name="error_messages" rows="4">{!! old('error_messages') ?? $form->error_messages !!}</textarea>
                                        @include('cms::panel.inc.form_error',['input_name' => 'error_messages'])
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success" id="submit" value="">
                                            {!! trans('cms::panel.forms.save') !!}
                                        </button>
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
