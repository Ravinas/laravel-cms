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

    <script>
        $('.description, .keywords, .robots').on('change',function () {
            var description = $('#description'+$(this).data('id')).val();
            var keywords = $('#keywords'+$(this).data('id')).val();
            if($('#robots'+$(this).data('id')).is(':checked')){
                var robots = 1;
            } else {
                var robots = 0;
            }
            //var robots = $('#robots'+$(this).data('id')).val();
            var meta_id = $(this).data('id')
            $.ajax('{!! route('metas.update',['meta' => $metas->first()]) !!}', {
                type: 'POST',  // http method
                data: {
                    _method: 'PUT',
                    _token: '{{ csrf_token() }}',
                    meta_id: meta_id,
                    description: description,
                    keywords: keywords,
                    robots: robots
                },  // data to submit
                success: function (data, status, xhr) {
                    console.log("success");
                    $('#description'+meta_id).closest('tr').css('background-color','#6c6').css('transition','background-color 1s');
                    setTimeout(function(){ $('#description'+meta_id).closest('tr').css('background-color','white') }, 3000);
                },
                error: function (jqXhr, textStatus, errorMessage) {
                    console.log("error");
                }
            });
        })
    </script>
@endpush

@section('content')

    <div class="main-content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-content">
                    <div class="card-body">
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.metas.title') }}</div>
                        </div>
                        <div class="alert alert-secondary">
                            <i data-feather="info"></i>{{ trans('cms::panel.metas.info') }}
                        </div>
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.metas.list') }}</div>

{{--                            <div class="form-group">--}}
{{--                                @can('create',CMS\Models\Meta::class)--}}
{{--                                    <a class="btn icon icon-left btn-primary float-right" href="{!! route('redirects.create') !!}"><i data-feather="plus-circle" ></i>{!! trans('cms::panel.redirects_create') !!}</a>--}}
{{--                                @endcan--}}
{{--                            </div>--}}
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class='table table-hover' id="myTable">
                                        <thead >
                                        <tr>
                                            <th>{!! trans('cms::panel.metas.url') !!}</th>
                                            <th>{!! trans('cms::panel.metas.name') !!}</th>
                                            <th>{!! trans('cms::panel.metas.description') !!}</th>
                                            <th>{!! trans('cms::panel.metas.keywords') !!}</th>
                                            <th>{!! trans('cms::panel.metas.robots') !!}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($metas as $meta)
                                            <tr>
                                                @if($meta->url == "/")
                                                    <td><a href="{!! substr(config('app.url'),0,-1).$meta->url !!}">{!! substr(config('app.url'),0,-1).$meta->url !!}</a> </td>
                                                @else
                                                    <td><a href="{!! config('app.url').$meta->url !!}">{!! config('app.url').$meta->url !!}</a> </td>
                                                @endif
                                                <td>{!! $meta->name !!}</td>
                                                <input type="hidden" name="edited" value="0">
                                                <td><input class="form-control description font-14" type="text" data-id="{!! $meta->id !!}" id="description{!! $meta->id !!}" name="description[{!! $meta->id !!}]" value="{!! $meta->description !!}" ></td>
                                                <td><input class="form-control keywords font-14" type="text" data-id="{!! $meta->id !!}" id="keywords{!! $meta->id !!}" name="keywords[{!! $meta->id !!}]" value="{!! $meta->keywords !!}" ></td>
                                                <td>
                                                    <input type="hidden" name="robots[{!! $meta->id !!}]" value="0">
                                                    <input class="form-check-sm robots" type="checkbox" id="robots{!! $meta->id !!}" data-id="{!! $meta->id !!}" name="robots[{!! $meta->id !!}]" value="1" {!! $meta->robots ? 'checked' : '' !!}>
                                                    <label for="robots{!! $meta->id !!}"></label>
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
