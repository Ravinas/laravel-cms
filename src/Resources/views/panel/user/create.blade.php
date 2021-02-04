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
                            <div class="divider-text">{{ trans('cms::panel.users_create') }}</div>
                        </div>
                        <div class="alert alert-secondary">
                            <i data-feather="info"></i>{{ trans('cms::panel.users_createinfo') }}
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form method="POST" action="{!! route('users.store') !!}">
                                    @method('POST')
                                    @csrf
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.users_role') !!}</label>
                                        <select class="form-control" id="role" name="role">
                                            <option selected disabled>{!! trans('cms::panel.users_selectrole') !!}</option>
                                            @foreach($roles as $role)
                                                <option value="{!! $role->id !!}" @if(old('role') == $role->id) selected @endif>{!! $role->name !!}</option>
                                            @endforeach!
                                        </select>
                                        @include('cms::panel.inc.form_error',['input_name' => 'role'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.users_name') !!}</label>
                                        <input type="text" class="form-control" id="name" name="name"  value="{!! old('name') !!}">
                                        @include('cms::panel.inc.form_error',['input_name' => 'name'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.users_email') !!}</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{!! old('email') !!}">
                                        @include('cms::panel.inc.form_error',['input_name' => 'email'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.users_password') !!}</label>
                                        <input type="password" class="form-control" id="password" name="password" >
                                        @include('cms::panel.inc.form_error',['input_name' => 'password'])
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.users_password_confirmation') !!}</label>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                        @include('cms::panel.inc.form_error',['input_name' => 'password_confirmation'])
                                    </div>
                                    <div class="form-group page-date">
                                        <input type="submit" class="form-control btn-primary col-3" id="submit" value="{!! trans('cms::panel.users_create') !!}">
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
