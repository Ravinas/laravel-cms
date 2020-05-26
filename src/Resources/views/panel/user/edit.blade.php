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
                            <form method="POST" action="{!! route('users.update' , ['user' => $user]) !!}">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label>{!! trans('cms::user.role') !!}</label>
                                    <select class="form-control" id="role" name="role">
                                        <option>{!! trans('cms::user.select_role') !!}</option>
                                        @foreach($roles as $role)
                                            <option value="{!! $role->id !!}" @if(old('role') == $role->id) selected @elseif($user->role_id == $role->id) selected @endif>{!! $role->name !!}</option>
                                        @endforeach!
                                    </select>
                                    @include('cms::panel.inc.form_error',['input_name' => 'role'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::user.name') !!}</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="{!! trans('cms::user.name') !!}" value="{!! old('name') ?? $user->name !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'name'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::user.email') !!}</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="{!! trans('cms::user.email') !!}" value="{!! old('email') ?? $user->email !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'email'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::user.password') !!}</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="{!! trans('cms::user.password') !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'password'])
                                </div>
                                <div class="form-group">
                                    <label>{!! trans('cms::user.password_confirmation') !!}</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="{!! trans('cms::user.password_confirmation') !!}">
                                    @include('cms::panel.inc.form_error',['input_name' => 'password_confirmation'])
                                </div>
                                <div class="form-group page-date">
                                    <input type="submit" class="form-control btn-primary col-3" id="submit" value="{!! trans('cms::user.edit') !!}">
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
