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
                            <h4 class="card-title">{!! trans('cms::role.roles') !!}</h4>
                            <a class="btn-success btn float-right" href="{!! route('roles.create') !!}">{!! trans('cms::role.create') !!}</a>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{!! trans('cms::role.id') !!}</th>
                                        <th>{!! trans('cms::role.name') !!}</th>
                                        <th>{!! trans('cms::role.action') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($roles as $role)
                                    <tr>
                                        <td>{!! $role->id !!}</td>
                                        <td>{!! $role->name !!}</td>
                                        <td>
                                            <a href="{!! route('roles.edit' , ['role' => $role]) !!}" class="btn waves-effect waves-light btn-warning hidden-sm-down">{!! trans('cms::role.edit') !!}</a>
                                            @include('cms::panel.inc.delete_modal',['trans_file' => 'role', 'model' => $role, 'route_group' => 'roles', 'route_parameter' => 'role'])
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
