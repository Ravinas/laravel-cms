@extends('cms::panel.newinc.app')
@section('content')
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>{!! Str::ucfirst($menu->text)  !!}</h3>
        <p class="text-subtitle text-muted">{{ trans('cms::panel.menu_items_info') }}</p>
    </div>
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class='card-heading p-1 pl-3 float-left'>{!! trans('cms::panel.items') !!}</h3>
                        <button type="button" class="btn icon icon-left btn-primary float-right" data-toggle="modal" data-target="#inlineForm"><i data-feather="edit" ></i>{{ trans('cms::panel.add') }}</button>
                        <div class="form-group">
                            <!--Modal -->
                            <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel33" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel33">{{ trans('panel.crate_menu_item') }} </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                    </div>
                                    <form id="menuform">
                                    <input type="hidden" name="menu_id" value="{!! $menu->id !!}">
                                    <div class="modal-body">
                                        <label>{{ trans('cms::panel.text') }}</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="{{ trans('panel.text') }}" autocomplete="none" class="form-control" name="text" required>
                                        </div>
                                        <label>{{ trans('cms::panel.type') }}</label>
                                        <div class="form-group">
                                            <select class="form-select" id="basicSelect" name="type">
                                                <option value="1">{{ trans('cms::panel.single') }}</option>
                                                <option value="2">{{ trans('cms::panel.dropdwon') }}</option>
                                            </select>
                                        </div>
                                        <label>{{ trans('cms::panel.url_type') }}</label>
                                        <div class="form-group">
                                            <select class="form-select" id="basicSelect" name="link_type">
                                                <option value="0">{{ trans('cms::panel.internal') }}</option>
                                                <option value="1">{{ trans('cms::panel.external') }}</option>
                                            </select>
                                        </div>
                                        <label>Tip</label>
                                        <div class="form-group">
                                            <select class="form-select" id="basicSelect" name="link">
                                                @foreach($urls as $url)
                                                    <option value="{!! $url->url !!}">{!!  $url->url !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label>{{ trans('panel.icon') }}</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="inputGroupFileAddon01"><i data-feather="upload"></i></span>
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                    <label class="form-file-label" for="inputGroupFile01">
                                                        <span class="form-file-text">{{ trans('cms::panel.choose_icon') }}</span>
                                                        <span class="form-file-button">{{ trans('cms::panel.upload') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block" id="post">{{ trans('cms::panel.create') }}</span>
                                        </button>
                                    </div>
                                    </form>
                                </div>
                                </div>
                            </div>
                            <!--Edit Modal -->
                            <div class="modal fade text-left" id="editinlineForm" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel33" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel33">{{ trans('cms::panel.edit_menu_item') }}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                    </div>
                                    <form id="editform">
                                    <input type="hidden" id="edit_item_id" name="item_id" value="{!! $menu->id !!}">
                                    <div class="modal-body">
                                        <label>Metin </label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Menüde Görünmesini İstediğiniz Metin (Örn: Hakkımızda)" class="form-control" name="edit_text" autocomplete="none" required id="edit_text">
                                        </div>
                                        <label>Tip</label>
                                        <div class="form-group">
                                            <select class="form-select" id="edit_type" name="edit_type">
                                                <option value="1">{{ trans('cms::panel.single') }}</option>
                                                <option value="2">{{ trans('cms::panel.dropdwon') }}</option>
                                            </select>
                                        </div>
                                        <label>Bağlantı Tipi</label>
                                        <div class="form-group">
                                            <select class="form-select" id="edit_link_type" name="edit_link_type">
                                                <option value="0">{{ trans('cms::panel.internal') }}</option>
                                                <option value="1">{{ trans('cms::panel.external') }}</option>
                                            </select>
                                        </div>
                                        <label>Bağlantı</label>
                                        <div class="form-group">
                                            <select class="form-select" id="edit_link" name="edit_link">
                                                @foreach($urls as $url)
                                                    <option value="{!! $url->url !!}">{!!  $url->url !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label>{{ trans('panel.icon') }}</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="inputGroupFileAddon01"><i data-feather="upload"></i></span>
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                    <label class="form-file-label" for="inputGroupFile01">
                                                        <span class="form-file-text">{{ trans('cms::panel.choose_icon') }}</span>
                                                        <span class="form-file-button">{{ trans('cms::panel.upload') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block" id="edit_post">{{ trans('cms::panel.create') }}</span>
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
                                    <div class="list-group-item d-flex justify-content-end align-items-center" style="{{ $item->parent_id == 0 ? 'border-color:#26c6da;color:black;' : 'background-color:#D1F8F8;' }}">
                                      <span class="mr-auto p-2">{!! Str::ucfirst($item->text)  !!}</span>
                                      <a href="#" class="btn icon btn-info ml-2 edit_item" data-id="{!! $item->id !!}"><i data-feather="plus-circle"></i></a>
                                      <a href="{!! route('delete-item',['menuitem' => $item->id]) !!}" class="btn icon btn-danger ml-2 del" data-id="{!! $item->id !!}" ><i data-feather="delete"></i></a>
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



        $('#edit_post').click(function (e) {
         e.preventDefault();
         var csrf = "{!! csrf_token() !!}";
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf
            }
        });

         $.ajax({
             url:'{!! route('edit-menuitem-ajax') !!}',
             method:'post',
             data:$('#editform').serialize(),
             success:function (response) {
                 if (response.success == "Ok")
                 {
                    $('#editinlineForm').modal('hide');
                    window.location.reload(true);
                 }
             }
         });
        });


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


        $('.edit_item').click(function(e){
            e.preventDefault();

            var item = $(this).attr('data-id');
            var csrf = "{!! csrf_token() !!}";
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf
            }
        });
         $.ajax({
             url:'{!! route('get-menuitem') !!}',
             method:'post',
             data:{id:item},
             dataType: 'json',
             success:function (response) {
                $('#edit_text').val(response.text);
                $('#edit_link_type option[value='+response.link_type+']').attr('selected','selected');
                $('#edit_type option[value='+response.type+']').attr('selected','selected');
                $('#edit_link option[value='+response.url+']').attr('selected','selected');
                $('#edit_item_id').val(item);
                $('#editinlineForm').modal('toggle');
             }
         });
        });
    });
  </script>
@endpush

