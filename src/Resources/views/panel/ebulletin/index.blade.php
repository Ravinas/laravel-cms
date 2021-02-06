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
                            <div class="divider-text">{{ trans('cms::panel.ebulletins.title') }}</div>
                        </div>
                        <div class="alert alert-secondary">
                            <i data-feather="info"></i>{{ trans('cms::panel.ebulletins.info') }}
                        </div>
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.ebulletins.user_list') }}</div>

                            <div class="form-group">

                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class='table table-hover' id="myTable">
                                        <thead >
                                        <tr>
                                            <th>{!! trans('cms::panel.ebulletins.id') !!}</th>
                                            <th>{!! trans('cms::panel.ebulletins.email') !!}</th>
                                            <th>{!! trans('cms::panel.ebulletins.language') !!}</th>
                                            <th>{!! trans('cms::panel.ebulletins.status') !!}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($ebulletins as $e)
                                            <tr>
                                                <td>{!! $e->id !!}</td>
                                                <td>{!! $e->email !!}</td>
                                                <td>{!! $e->name !!}</td>
                                                @if($e->status)
                                                    <td class="text-success">{!! trans('cms::panel.ebulletins.active') !!}</td>
                                                @else
                                                    <td class="text-disabled font-italic">{!! trans('cms::panel.ebulletins.passive') !!}</td>
                                                @endif
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
