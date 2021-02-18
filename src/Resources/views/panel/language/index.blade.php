@extends('cms::panel.newinc.app')
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

@endpush
@section('content')
<div class="main-content container-fluid">

    <div class="card">
        <div class="card-header">
            <div class="card-content">
                <div class="card-body">
                    <div class="divider">
                        <div class="divider-text">{{ trans('cms::panel.languages.title') }}</div>
                    </div>
                    <div class="alert alert-secondary">
                        <i data-feather="info"></i>{{ trans('cms::panel.languages.info') }}
                    </div>
                    <div class="alert alert-secondary">
                        <i data-feather="globe"></i>{{ trans('cms::panel.languages.default_language') }} <b>{!! $langs->default_language->name !!}</b>
                    </div>
                    <div class="alert alert-secondary">
                        <i data-feather="eye"></i>{{ trans('cms::panel.languages.extensions') }}  <u class="extension_submit" style="font-wariant:bold;cursor:pointer">{!! trans('cms::panel.languages.'.$langs->extensions["text"]) !!}</u>.
                        <input type="hidden" value="{!! $langs->extensions["key"] !!}" name="ext" class="ext">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <section id="list-group-icons">
        <div class="row match-height">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.languages.list') }}</div>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="alert alert-secondary">
                                    <i data-feather="info"></i>{{ trans('cms::panel.languages.mark') }}
                                </div>
                            <table class='table table-hover' id="myTable">
                                <thead >
                                    <tr>
                                        <th>{!! trans('cms::panel.languages.name') !!}</th>
                                        <th>{!! trans('cms::panel.languages.slug') !!}</th>
                                        <th>{!! trans('cms::panel.languages.status') !!}</th>
                                        <th style="width: 10%;">{!! trans('cms::panel.languages.default') !!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($langs as $lang)
                                    <tr>
                                        <td>{{ $lang->name }}</td>
                                        <td>{{ $lang->code }}</td>
                                        @if ($loop->first)
                                        <td>
                                            <input type="hidden" value="false" name="hidden_id">
                                            <span style="cursor: not-allowed;" id="{!! $lang->id !!}" class="{{ $lang->status ? 'btn icon btn-warning' : 'btn icon btn-danger' }} default_language"><i data-feather="globe"></i></span>
                                        </td>
                                        @else
                                        <td>
                                            <input type="hidden" value="{!! $lang->id !!}" name="hidden_id">
                                            <span id="{!! $lang->id !!}" class="{{ $lang->status ? 'btn icon btn-success' : 'btn icon btn-danger' }} ajax_request" style="cursor: pointer;">{!! $lang->status ? '<i data-feather="check-circle"></i>' : '<i data-feather="lock"></i>' !!}</span>
                                        </td>
                                        @endif
                                        <td style="width: 1%;">
                                            <input type="hidden" value="{!! $lang->id !!}" name="default_id">
                                            <span  {!! $loop->first ? 'style="cursor: not-allowed;"' : '' !!} id="{!! $lang->id !!}"  class="btn icon change_default {!! $loop->first ? 'btn-warning' : 'btn-primary' !!} float-right">{!! $loop->first ? 'Varsayılan' : '<i data-feather="globe"></i>' !!}</span>
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
    </section>
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
    <script type="text/javascript">

        $(document).ready( function () {


            feather.replace();

            $('#myTable').DataTable( {
                "language": {

                    "zeroRecords": "Üzgünüz burada herhangi bir şey yok",
                    "info": "Gösterilen sayfa",
                    "infoEmpty": "Üzgünüz burada herhangi bir şey yok",
                    "infoFiltered": "Filtrelenmiş eposta sayısı"
                },
                "paging":   true,
                "ordering": false,
                "info":     true
            } );

        var csrf = "{!! csrf_token() !!}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf
            }
        });

        $('#myTable').on('click','.ajax_request',function(e){
            var id = $(this).prev().val();
            console.log(id);
            $.ajax({
                url:'{!! route('updateList') !!}',
                method:'POST',
                type:'JSON',
                data:{id:id},
                success:function(response){
                    if(response.Message == "Ok")
                    {
                        if(response.Status == 1)
                        {
                            $('#'+id).removeClass().addClass( "btn icon btn-success" );
                            $('#'+id).html("<i data-feather='check-circle'></i>");
                            $('.toast-body').html("{!! trans('cms::panel.languages.active_passive') !!}");
                            $('#myToast').toast('show');
                            feather.replace();
                        }else{
                            $('#'+id).removeClass().addClass( "btn icon btn-danger" );
                            $('#'+id).html("<i data-feather='lock'></i>");
                            feather.replace();
                            $('.toast-body').html("{!! trans('cms::panel.an_error') !!}");
                            $('#myToast').toast('show');
                        }
                    }else{
                        console.log(response.Message);
                    }
                }
            });
        });

        $('.extension_submit').click(function(){
                var choosen = $(this).next().val();
                $.ajax({
                    url:'{!! route('update.Extensions') !!}',
                    method:'POST',
                    type:'JSON',
                    data:{choosen:choosen},
                    success:function(response){
                        if(response.Message == "Ok")
                        {

                            if(response.Code == 1)
                            {
                                $('.ext').val(0);
                                $('.extension_submit').html("{!! trans('cms::panel.languages.open') !!}");
                                $('.toast-body').html("{!! trans('cms::panel.languages.extensions_opened') !!}");
                                $('#myToast').toast('show');
                            }else{
                                $('.ext').val(1)
                                $('.extension_submit').html("{!! trans('cms::panel.languages.close') !!}");
                                $('.toast-body').html("{!! trans('cms::panel.languages.extensions_closed') !!}");
                                $('#myToast').toast('show');
                            }
                        }
                    }
                });
        });

        $('.change_default').click(function(){
                var choosen = $(this).prev().val();
                $.ajax({
                    url:'{!! route('change.default') !!}',
                    method:'POST',
                    type:'JSON',
                    data:{choosen:choosen},
                    success:function(response){
                        if(response.Message == "Ok")
                        {
                            $('.toast-body').html("{!! trans('cms::panel.languages.default_changed') !!}");
                            $('#myToast').toast('show');
                            window.location.reload();
                        }else{
                            $('.toast-body').html("{!! trans('cms::panel.an_error') !!}");
                            $('#myToast').toast('show');

                            }
                    }
                });
        });

    });
        </script>
@endpush
