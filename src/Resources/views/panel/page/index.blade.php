@extends('cms::panel.inc.app')
@push('css')

@endpush

@push('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-html5-1.6.2/b-print-1.6.2/r-2.2.5/sc-2.0.2/datatables.min.js"></script>
<script>

    $(document).ready( function () {
        $('#tbl').DataTable();
    } );
    </script>
@endpush
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            @include('cms::panel.inc.breadcrumb')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">{!! trans('cms::panel.pages') !!}</h4>
                            <a class="btn-success btn float-right" href="{!! route('pages.create') !!}">{!! trans('cms::panel.create') !!}</a>
                            <div class="table-responsive">
                                <table class="table" id="tbl">
                                    <thead>
                                    <tr>
                                        <th>{!! trans('cms::panel.id') !!}</th>
                                        <th>{!! trans('cms::panel.name') !!}</th>
                                        <th>{!! trans('cms::panel.url') !!}</th>
                                        <th>{!! trans('cms::panel.action') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($pages as $page)
                                    <tr>
                                        <td>{!! $page->id !!}</td>
                                        <td>{!! $page->name !!}</td>
                                        <td>{!! $page->url !!}</td>
                                        <td>
                                            @can('edit',$page)
                                                <a href="{!! route('pages.edit' , ['page' => $page->id]) !!}" class="btn waves-effect waves-light btn-warning hidden-sm-down">{!! trans('cms::panel.edit') !!}</a>
                                            @endcan
                                            @if($page->type == 1)
                                                <a href="{!! route('subpages' , ['id' => $page->id]) !!}" class="btn waves-effect waves-light btn-success hidden-sm-down ml-1">{!! trans('cms::panel.sub_pages') !!}</a>
                                            @endif
                                            @can('delete',$page)
                                                @include('cms::panel.inc.delete_modal',['trans_file' => 'page', 'model' => $page, 'route_group' => 'pages', 'route_parameter' => 'page'])
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
@endsection
