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
                            <div class="divider-text">{{ trans('cms::panel.roles.title') }}</div>
                        </div>
                        <div class="alert alert-secondary">
                            <i data-feather="info"></i>{{ trans('cms::panel.roles.info') }}
                        </div>
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.roles.list') }}</div>

                            <div class="form-group">
                                <a class="btn icon icon-left btn-primary float-right" href="{!! route('roles.create') !!}"><i data-feather="plus-circle" ></i>{!! trans('cms::panel.roles.create') !!}</a>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class='table table-hover' id="myTable">
                                        <thead >
                                        <tr>
                                            <th>{!! trans('cms::panel.roles.id') !!}</th>
                                            <th>{!! trans('cms::panel.roles.name') !!}</th>
                                            <th>{!! trans('cms::panel.users.action') !!}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($roles as $role)
                                            <tr>
                                                <td>{!! $role->id !!}</td>
                                                <td>{!! $role->name !!}</td>
                                                <td>
                                                    <a href="{!! route('roles.edit' , $role) !!}" class="btn btn-warning icon"><i data-feather="edit"></i> {!! trans('cms::panel.edit') !!}</a>
                                                    @component('cms::panel.newinc.delete_modal',[ 'model' => $role, 'route_group' => 'roles'])
                                                        {!! trans('cms::panel.roles.delete_text') !!}
                                                    @endcomponent
{{--                                                    @include('cms::panel.inc.delete_modal',['trans_file' => 'role', 'model' => $role, 'route_group' => 'roles', 'route_parameter' => 'role'])--}}
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
