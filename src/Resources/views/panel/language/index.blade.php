@extends('cms::panel.newinc.app')
@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

@endpush
@section('content')
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Dil Seçimi</h3>
        <p class="text-subtitle text-muted">Sitenizin varsayılan dilini ve diğer aktif dillerini düzenleyin.</p>
    </div>
    <section id="list-group-icons">
        <div class="row match-height">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Varsayılan Dil</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p>
                                Sitenizde varsayılan olarak kullanılan dil <u style="color: #41B1F9;font-wariant:bold;">{!! $default_language->name !!}</u>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Aktif Diller</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <p>
                               Sitenizde aktif olmasını istediğini dilleri işaretleyiniz.
                            </p>
                            <table class='table table-striped display !important' id="myTable">
                                <thead>
                                    <tr>
                                        <th>{!! trans('cms::panel.name') !!}</th>
                                        <th>{!! trans('cms::panel.slug') !!}</th>
                                        <th>{!! trans('cms::panel.status') !!}</th>
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
                                            <span style="cursor: not-allowed;" id="{!! $lang->id !!}" class="{{ $lang->status ? 'badge bg-info' : 'badge bg-danger' }} default_language">{!! $lang->status ? 'Active' : 'Passive' !!}</span>
                                        </td>
                                        @else
                                        <td>
                                            <input type="hidden" value="{!! $lang->id !!}" name="hidden_id">
                                            <span id="{!! $lang->id !!}" class="{{ $lang->status ? 'badge bg-success' : 'badge bg-danger' }} ajax_request" style="cursor: grab;">{!! $lang->status ? 'Active' : 'Passive' !!}</span>
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

        $('#myTable').DataTable( {
            "language": {
                "lengthMenu": "Sayfa başına gösterilen eposta sayısı",
                "zeroRecords": "Üzgünüz burada herhangi bir şey yok",
                "info": "Gösterilen sayfa",
                "infoEmpty": "Üzgünüz burada herhangi bir şey yok",
                "infoFiltered": "Filtrelenmiş eposta sayısı"
            },
            "paging":   true,
            "ordering": false,
            "info":     true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        } );

        var csrf = "{!! csrf_token() !!}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf
            }
        });

        $('.ajax_request').click(function(e){
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
                            $('#'+id).removeClass().addClass( "badge bg-success" );
                            $('#'+id).html("Active");
                        }else{
                            $('#'+id).removeClass().addClass( "badge bg-danger" );
                            $('#'+id).html("Passive");
                        }
                    }else{
                        console.log(response.Message);
                    }
                }
            });
        });
    } );
        </script>
@endpush
