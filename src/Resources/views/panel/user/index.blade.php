@extends('cms::panel.newinc.app')
@push('css')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
@endpush

@push('js')
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script>

        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
@endpush
@section('content')

    <div class="main-content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-content">
                    <div class="card-body">
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.users') }}</div>
                        </div>
                        <div class="alert alert-secondary">
                            <i data-feather="info"></i>{{ trans('cms::panel.users_info') }}
                        </div>
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.users_list') }}</div>

                            <div class="form-group">
                                <a class="btn icon icon-left btn-primary float-right" href="{!! route('users.create') !!}"><i data-feather="plus-circle" ></i>{!! trans('cms::panel.users_create') !!}</a>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class='table table-hover' id="myTable">
                                        <thead >
                                        <tr>
                                            <th>{!! trans('cms::panel.users_id') !!}</th>
                                            <th>{!! trans('cms::panel.users_name') !!}</th>
                                            <th>{!! trans('cms::panel.users_email') !!}</th>
                                            <th>{!! trans('cms::panel.users_role') !!}</th>
                                            <th>{!! trans('cms::panel.users_action') !!}</th>
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
                                                    <a href="{!! route('users.edit' , ['user' => $user]) !!}" class="btn waves-effect waves-light btn-warning hidden-sm-down"><i data-feather="edit"></i>{!! trans('cms::user.edit') !!}</a>
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
    </div>
@endsection

@section('old')
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
