@extends('cms::panel.newinc.app')
@push('css')

@endpush

@push('js')
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
                            <div class="divider-text">{{ trans('cms::panel.redirects.title') }}</div>
                        </div>
                        <div class="alert alert-secondary">
                            <i data-feather="info"></i>{{ trans('cms::panel.redirects.info') }}
                        </div>
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.redirects.list') }}</div>

                            <div class="form-group">
                                @can('create',CMS\Models\Redirect::class)
                                    <a class="btn icon icon-left btn-primary float-right" href="{!! route('redirects.create') !!}"><i data-feather="plus-circle" ></i>{!! trans('cms::panel.redirects.create') !!}</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class='table table-hover' id="myTable">
                                        <thead >
                                        <tr>
                                            <th>{!! trans('cms::panel.id') !!}</th>
                                            <th>{!! trans('cms::panel.redirects.from') !!}</th>
                                            <th>{!! trans('cms::panel.redirects.to') !!}</th>
                                            <th>{!! trans('cms::panel.redirects.code') !!}</th>
                                            <th>{!! trans('cms::panel.redirects.action') !!}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($redirects as $redirect)
                                            <tr>
                                                <td>{{ $redirect->id }}</td>
                                                <td>{{ $redirect->from }}</td>
                                                <td>{{ $redirect->to }}</td>
                                                <td>{{ $redirect->code }}</td>
                                                <td>

                                                    <a href="{!! route('redirects.edit' , $redirect) !!}" class="btn btn-warning icon"><i data-feather="edit" ></i> {!! trans('cms::panel.edit') !!}</a>
                                                    @can('delete',CMS\Models\Redirect::class)
                                                        @component('cms::panel.newinc.delete_modal',[ 'model' => $redirect, 'route_group' => 'redirects'])
                                                            {!! trans('cms::panel.redirects.delete_text') !!}
                                                        @endcomponent
                                                    @endcan
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
