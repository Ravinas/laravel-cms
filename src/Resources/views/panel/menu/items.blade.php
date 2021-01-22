@extends('cms::panel.newinc.app')
@section('content')
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Ana Menü</h3>
        <p class="text-subtitle text-muted">Bu kısımda Ana Menü'nün elemanlarını ekleyebilir , silebilir ve sıraya sokabilirsiniz</p>
    </div>
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class='card-heading p-1 pl-3 float-left'>{!! trans('cms::panel.items') !!}</h3>
                        <button type="button" class="btn icon icon-left btn-primary float-right" data-toggle="modal" data-target="#inlineForm"><i data-feather="edit" ></i> Eleman Ekleyin</button>
                        <div class="form-group">
                            <!--Modal -->
                            <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel33" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel33">Menü Elemanı Oluştur </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                    </div>
                                    <form id="menuform">
                                    <input type="hidden" name="menu_id" value="{!! $menu->id !!}">
                                    <div class="modal-body">
                                        <label>Metin </label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Menüde Görünmesini İstediğiniz Metin (Örn: Hakkımızda)" class="form-control" name="text" required>
                                        </div>
                                        <label>Tip</label>
                                        <div class="form-group">
                                            <select class="form-select" id="basicSelect" name="type">
                                                <option value="1">Single</option>
                                                <option value="2">Dropdown</option>
                                            </select>
                                        </div>
                                        <label>Bağlantı Tipi</label>
                                        <div class="form-group">
                                            <select class="form-select" id="basicSelect" name="link_type">
                                                <option value="0">Internal</option>
                                                <option value="1">External</option>
                                            </select>
                                        </div>
                                        <label>Tip</label>
                                        <div class="form-group">
                                            <select class="form-select" id="basicSelect" name="type">
                                                @foreach($urls as $url)
                                                    <option value="{!! $url->url !!}">{!!  $url->url !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label>İkon (İsteğe Bağlı)</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="inputGroupFileAddon01"><i data-feather="upload"></i></span>
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                    <label class="form-file-label" for="inputGroupFile01">
                                                        <span class="form-file-text">İkon seçin..</span>
                                                        <span class="form-file-button">Yükle</span>
                                                    </label>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block" id="post">Oluştur</span>
                                        </button>
                                    </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <ol class="sortable" style="list-style: none;">
                                @foreach ($menu_items as $item)
                                <li class="mt-1" id="menuItem-{{$item->id}}" style="list-style: none;">
                                    <div class="list-group-item d-flex justify-content-end align-items-center">
                                      <span class="mr-auto p-2">{!! $item->text !!}</span>
                                      <a href="" class="btn icon btn-info ml-2" data-id="{!! $item->id !!}"><i data-feather="plus-circle"></i></a>
                                      <a href="{!! route('delete-item',['menuitem' => $item->id]) !!}" class="btn icon btn-danger ml-2 del" data-id="{!! $item->id !!}"><i data-feather="delete"></i></a>
                                    </div>
                                    @if($item->children)
                                        @include('cms::panel.menu.new-item-children',['childs' => $item->children])
                                    @endif
                                </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@push('js')
  <script src="{!! asset('vendor/cms/js/jquery.mjs.nestedSortable.js') !!}"></script>
  <script>
  $(document).ready(function(){
        $('ol.sortable').nestedSortable({
            handle: 'div',
            items: 'li',
            toleranceElement: '> div',
            stop:function(){
                sendList();
            }
        });

        function sendList(){
            var serialized = $('ol.sortable').nestedSortable('serialize');
            $.ajax({
            url: "{{ route('menuajax') }}",
            method: "POST",
            data: {sort: serialized,_token: '{{csrf_token()}}'},
                success: function(res) {
                    console.log("İşlem Başarılı");
                }
            });
        }

        $('#post').click(function (e) {
         e.preventDefault();
         var csrf = "{!! csrf_token() !!}";
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf
            }
        });

         $.ajax({
             url:'{!! route('menuitemajax') !!}',
             method:'post',
             data:$('#menuform').serialize(),
             success:function (response) {
                 if (response.Message == "Ok")
                 {
                     window.location.reload(true);
                 }
             }
         });
        });
    });
  </script>
@endpush

