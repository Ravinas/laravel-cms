@extends('cms::panel.newinc.app')
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
@endpush
@section('content')
<div class="main-content container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="card-body">
                <div class="divider">
                    <div class="divider-text">{!! trans('cms::panel.pages') !!}</div>
                </div>
                <div class="alert alert-secondary">
                    <i data-feather="info"></i>{!! trans('cms::panel.pages_info') !!}
                </div>
                <div class="row">
                    <div class="form-group">
                        <a class="btn icon icon-left btn-primary float-right" href="{!! route('pages.create') !!}"><i data-feather="plus-circle"></i>{!! trans('cms::panel.create') !!}</a>
                    </div>

                </div>
                <div class="divider">
                    <div class="divider-text">{!! trans('cms::panel.page_list') !!}</div>
                </div>


                <div class="card-body">

                    <div class="table-responsive">
                    <table class='table table-hover' id="myTable">
                        <thead>
                            <tr>
                                <th>{!! trans('cms::panel.id') !!}</th>
                                <th>{!! trans('cms::panel.page_title') !!}</th>
                                <th>{!! trans('cms::panel.url') !!}</th>
                                <th class="d-flex justify-content-end">{!! trans('cms::panel.action') !!}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pages as $page)
                            <tr>
                                @if(Auth::user()->hasPagePermission($page->id,'C'))
                                <td>{!! $page->id !!}</td>
                                <td>{!! $page->name !!}</td>
                                <td>{!! $page->url !!}</td>
                                <td class="d-flex justify-content-end">
                                    <a href="{!! route('pages.edit' , ['page' => $page->id]) !!}" class="btn icon btn-primary ml-1"><i data-feather="edit"></i></a>
                                    @if($page->type == 1)
                                    <a href="{!! route('subpages' , ['id' => $page->id]) !!}" class="btn icon btn-info ml-1 "><i data-feather="layout"></i></a>
                                    @endif
                                    @can('delete',\CMS\Models\Page::class)
                                        @if(Auth::user()->hasPagePermission($page->id,'D'))
                                        @include('cms::panel.inc.delete_modal',['trans_file' => 'page', 'model' => $page, 'route_group' => 'pages', 'route_parameter' => 'page'])
                                        @endif
                                    @endcan
                                </td>
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
@endsection
@push('js')
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script>
    $(document).ready( function () {
        $('#myTable').DataTable({
            "language": {
                "zeroRecords": "??zg??n??z burada herhangi bir ??ey yok",
                "info": "G??sterilen sayfa",
                "infoEmpty": "??zg??n??z burada herhangi bir ??ey yok",
                "infoFiltered": "Filtrelenmi?? eposta say??s??"
            },
            "paging":   true,
            "ordering": false,
            "info":     true,
        });

    });
</script>

@endpush
