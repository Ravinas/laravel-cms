@extends('cms::panel.inc.app')
@push('css')
    <style>
        tbody{
            font-size:14px;
        }
        input{

        }
    </style>
@endpush

@push('js')
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
    <div class="page-wrapper">
        <div class="container-fluid">
            @include('cms::panel.inc.breadcrumb')
            <div class="row">
                <div class="col-lg-12">
                    @include('cms::panel.inc.alert')
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">{!! trans('cms::meta.metas') !!}</h4>
{{--                            <a class="btn-success btn float-right" href="{!! route('roles.create') !!}">{!! trans('cms::meta.create') !!}</a>--}}
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{!! trans('cms::meta.url') !!}</th>
                                        <th>{!! trans('cms::meta.name') !!}</th>
                                        <th>{!! trans('cms::meta.description') !!}</th>
                                        <th>{!! trans('cms::meta.keywords') !!}</th>
                                        <th>{!! trans('cms::meta.robots') !!}</th>
                                    </tr>
                                    </thead>

                                    <tbody class="font-14">
                                    @foreach($metas as $meta)
                                    <tr>
                                        <td><a href="/{!! $meta->url !!}">{!! $meta->url !!}</a> </td>
                                        <td>{!! $meta->name !!}</td>
                                        <input type="hidden" name="edited" value="0">
                                        <td><input class="form-control description font-14" type="text" data-id="{!! $meta->id !!}" id="description{!! $meta->id !!}" name="description[{!! $meta->id !!}]" value="{!! $meta->description !!}" ></td>
                                        <td><input class="form-control keywords font-14" type="text" data-id="{!! $meta->id !!}" id="keywords{!! $meta->id !!}" name="keywords[{!! $meta->id !!}]" value="{!! $meta->keywords !!}" ></td>
                                        <td>
                                            <input type="hidden" name="robots[{!! $meta->id !!}]" value="0">
                                            <input class="form-control robots" type="checkbox" id="robots{!! $meta->id !!}" data-id="{!! $meta->id !!}" name="robots[{!! $meta->id !!}]" value="1" {!! $meta->robots ? 'checked' : '' !!}>
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
@endsection
