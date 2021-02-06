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
                            <div class="divider-text">{{ trans('cms::panel.users.title') }}</div>
                        </div>
                        <div class="alert alert-secondary">
                            <i data-feather="info"></i>{{ trans('cms::panel.users.info') }}
                        </div>
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.users.list') }}</div>

                            <div class="form-group">
                                <a class="btn icon icon-left btn-primary float-right" href="{!! route('users.create') !!}"><i data-feather="plus-circle" ></i>{!! trans('cms::panel.users.create') !!}</a>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class='table table-hover' id="myTable">
                                        <thead >
                                        <tr>
                                            <th>{!! trans('cms::panel.users.id') !!}</th>
                                            <th>{!! trans('cms::panel.users.name') !!}</th>
                                            <th>{!! trans('cms::panel.users.email') !!}</th>
                                            <th>{!! trans('cms::panel.users.role') !!}</th>
                                            <th>{!! trans('cms::panel.users.action') !!}</th>
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
                                                    <a href="{!! route('users.edit' , $user) !!}" class="btn btn-warning icon"><i data-feather="edit"></i>{!! trans('cms::panel.edit') !!}</a>
                                                    @if(Auth::user()->id != $user->id)
                                                        @component('cms::panel.newinc.delete_modal',[ 'model' => $user, 'route_group' => 'users'])
                                                            {!! trans('cms::panel.users.delete_text') !!}
                                                        @endcomponent
                                                    @endif
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
