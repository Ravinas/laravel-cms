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
                    @include('cms::panel.inc.alert')
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">{!! trans('cms::user.users') !!}</h4>
                            <a class="btn-success btn float-right" href="{!! route('users.create') !!}">{!! trans('cms::user.create') !!}</a>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{!! trans('cms::user.id') !!}</th>
                                        <th>{!! trans('cms::user.name') !!}</th>
                                        <th>{!! trans('cms::user.email') !!}</th>
                                        <th>{!! trans('cms::user.role') !!}</th>
                                        <th>{!! trans('cms::user.action') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{!! $user->id !!}</td>
                                        <td>{!! $user->name !!}</td>
                                        <td>{!! $user->email !!}</td>
                                        <td>{!! $user->roleName !!}</td>
                                        <td>
                                            <a href="{!! route('users.edit' , ['user' => $user]) !!}" class="btn waves-effect waves-light btn-warning hidden-sm-down">{!! trans('cms::user.edit') !!}</a>
                                            @include('cms::panel.inc.delete_modal',['trans_file' => 'user', 'model' => $user, 'route_group' => 'users', 'route_parameter' => 'user'])
                                        </td>
                                    </tr>
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
