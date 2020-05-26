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
                            <h2 class="card-title">{!! trans('cms::redirect.redirects') !!}</h2>
                            @can('create',CMS\Models\Redirect::class)
                            <a class="btn-success btn float-right" href="{!! route('redirects.create') !!}">{!! trans('cms::redirect.create') !!}</a>
                            @endcan
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{!! trans('cms::redirect.id') !!}</th>
                                        <th>{!! trans('cms::redirect.from') !!}</th>
                                        <th>{!! trans('cms::redirect.to') !!}</th>
                                        <th>{!! trans('cms::redirect.code') !!}</th>
                                        <th>{!! trans('cms::redirect.action') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($redirects as $redirect)
                                    <tr>
                                        <td>{!! $redirect->id !!}</td>
                                        <td>{!! $redirect->from !!}</td>
                                        <td>{!! $redirect->to !!}</td>
                                        <td>{!! $redirect->code !!}</td>
                                        <td>
                                            @can('update',$redirect)
                                            <a href="{!! route('redirects.edit' , ['redirect' => $redirect]) !!}" class="btn waves-effect waves-light btn-warning hidden-sm-down">{!! trans('cms::redirect.edit') !!}</a>
                                            @endcan
                                            @can('delete',$redirect)
                                                @include('cms::panel.inc.delete_modal', ['trans_file' => 'redirect', 'model' => $redirect, 'route_group' => 'redirects', 'route_parameter' => 'redirect'])
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>

{{--                                {{ $forms->links() }}--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
