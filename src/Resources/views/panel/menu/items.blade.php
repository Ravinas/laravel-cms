@extends('cms::panel.newinc.app')
@section('content')
<div class="main-content container-fluid">
    <div class="divider">
        <div class="divider-text">{!! Str::ucfirst($menu->name)  !!}</div>
    </div>
    <div class="alert alert-secondary">
        <i data-feather="info"></i>{{ trans('cms::panel.menus.items_info') }}
    </div>
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class='card-heading p-1 pl-3 float-left'>{!! trans('cms::panel.menus.items') !!}</h3>
                        <button type="button" class="btn icon icon-left btn-primary float-right" data-toggle="modal" data-target="#inlineForm"><i data-feather="plus-circle" ></i>{{ trans('cms::panel.menus.add') }}</button>
                        <button type="button" id="send_list" class="btn icon icon-left btn-warning float-right mr-2" style="display: none"><i data-feather="check-circle" ></i>{!! trans('cms::panel.menus.save_changes') !!}</button>
                        <div class="form-group">
                            <!--Modal -->
                            <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
                                aria-labelledby="myModalLabel33" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel33">{{ trans('cms::panel.menus.create_menu_item') }} </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                    </div>
                                    <form id="menuform">
                                    <input type="hidden" name="menu_id" value="{!! $menu->id !!}">
                                    <div class="modal-body">
                                        <label>{{ trans('cms::panel.menus.text') }}</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="{{ trans('cms::panel.menus.text') }}" autocomplete="off" class="form-control" name="text" required>
                                        </div>
                                        <label>{{ trans('cms::panel.menus.type') }}</label>
                                        <div class="form-group">
                                            <select class="form-select" id="basicSelect" name="type">
                                                <option value="1">{{ trans('cms::panel.menus.single') }}</option>
                                                <option value="2">{{ trans('cms::panel.menus.dropdown') }}</option>
                                            </select>
                                        </div>
                                        <label>{{ trans('cms::panel.menus.link_type') }}</label>
                                        <div class="form-group">
                                            <select class="form-select" id="basicSelect" name="link_type">
                                                <option value="0">{{ trans('cms::panel.menus.internal') }}</option>
                                                <option value="1">{{ trans('cms::panel.menus.external') }}</option>
                                            </select>
                                        </div>
                                        <label class="external_div" style="display: none;">{!! trans('cms::panel.menus.external_url') !!}</label>
                                        <div class="form-group external_div" style="display: none;">
                                            <input type="text" placeholder="" class="form-control" name="external" autocomplete="off"  id="external">
                                        </div>
                                        <label class="internal_div">{!! trans('cms::panel.menus.url') !!}</label>
                                        <div class="form-group internal_div">
                                            <select class="form-select" id="basicSelect" name="link">
                                                @foreach($urls as $url)
                                                    <option value="{!! $url->url !!}">{!!  $url->url !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label>{{ trans('cms::panel.menus.icon') }}</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="inputGroupFileAddon01"><i data-feather="upload"></i></span>
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                    <label class="form-file-label" for="inputGroupFile01">
                                                        <span class="form-file-text">{{ trans('cms::panel.menus.choose_icon') }}</span>
                                                        <span class="form-file-button">{{ trans('cms::panel.menus.upload') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block" id="post">{{ trans('cms::panel.menus.create') }}</span>
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
                                    <h4 class="modal-title" id="myModalLabel33">{{ trans('cms::panel.menus.edit_menu_item') }}</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                    </div>
                                    <form id="editform">
                                    <input type="hidden" id="edit_item_id" name="item_id" value="{!! $menu->id !!}">
                                    <div class="modal-body">
                                        <label>{!! trans('cms::panel.menus.text') !!}</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="Menüde Görünmesini İstediğiniz Metin (Örn: Hakkımızda)" class="form-control" name="edit_text" autocomplete="off" required id="edit_text">
                                        </div>
                                        <label>{!! trans('cms::panel.menus.type') !!}</label>
                                        <div class="form-group">
                                            <select class="form-select" id="edit_type" name="edit_type">
                                                <option value="1">{{ trans('cms::panel.menus.single') }}</option>
                                                <option value="2">{{ trans('cms::panel.menus.dropdown') }}</option>
                                            </select>
                                        </div>
                                        <label>{!! trans('cms::panel.menus.link_type') !!}</label>
                                        <div class="form-group">
                                            <select class="form-select" id="edit_link_type" name="edit_link_type">
                                                <option value="0">{{ trans('cms::panel.menus.internal') }}</option>
                                                <option value="1">{{ trans('cms::panel.menus.external') }}</option>
                                            </select>
                                        </div>
                                        <label class="external_div" style="display: none;">{!! trans('cms::panel.menus.external_url') !!}</label>
                                        <div class="form-group external_div" style="display: none;">
                                            <input type="text" placeholder="" class="form-control" name="edit_external" autocomplete="off"  id="edit_external">
                                        </div>
                                        <label class="internal_div">{!! trans('cms::panel.menus.url') !!}</label>
                                        <div class="form-group internal_div">
                                            <select class="form-select" id="edit_link" name="edit_link">
                                                @foreach($urls as $url)
                                                    <option value="{!! $url->url !!}">{!!  $url->url !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <label>{{ trans('cms::panel.menus.icon') }}</label>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="inputGroupFileAddon01"><i data-feather="upload"></i></span>
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                    <label class="form-file-label" for="inputGroupFile01">
                                                        <span class="form-file-text">{{ trans('cms::panel.menus.choose_icon') }}</span>
                                                        <span class="form-file-button">{{ trans('cms::panel.menus.upload') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block" id="edit_post">{{ trans('cms::panel.menus.create') }}</span>
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
                                      <a href="#" class="btn icon btn-danger ml-2 del" data-url="{!! route('delete-item') !!}" data-id="{!! $item->id !!}" ><i data-feather="delete"></i></a>
                                    </div>
                                    @if($item->children)
                                        @include('cms::panel.menu.item-children',['childs' => $item->children])
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
                $('#send_list').removeClass().addClass("btn icon icon-left btn-warning float-right mr-2");
                $('#send_list').show();
            }
        });
        $('#send_list').click(function(){
            var serialized = $('ol.sortable').nestedSortable('serialize');
            $.ajax({
            url: "{{ route('menuajax') }}",
            method: "POST",
            data: {sort: serialized,_token: '{{csrf_token()}}'},
                success: function(res) {
                    $('#send_list').removeClass().addClass("btn icon icon-left btn-success float-right mr-2").html("Changes Saved").fadeOut(3000);
                    console.log("İşlem Başarılı");
                }
            });
        });

        $('#edit_link_type').on('change',function(){
            if($(this).val() == 0)
            {
                $('.external_div').hide();
                $('.internal_div').show();
            }else{
                $('.external_div').show();
                $('.internal_div').hide();
            }

        });


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
                if(response.link_type == 1)
                {
                    $('.external_div').html(response.external);
                    $('.internal_div').hide();
                }
                $('#edit_type option[value='+response.type+']').attr('selected','selected');
              //  $('#edit_link option[value='+response.url+']').attr('selected','selected');
                $('#edit_item_id').val(item);
                $('#editinlineForm').modal('toggle');
             }
         });
        });

        $('.del').click(function(){
            var csrf = "{!! csrf_token() !!}";
            var id = $(this).attr("data");
            var url =$(this).attr("data-url");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrf
                }
            });
            Swal.fire({
                title: '{!! trans('cms::panel.menus.confirm') !!}',
                text: "{!! trans('cms::panel.menus.confirm_submenus') !!}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{!! trans('cms::panel.menus.delete_confirm') !!}'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:url,
                        method:'POST',
                        dataType: "JSON",
                        data: {
                        "menu": id
                        },
                        success:function (response) {
                            Swal.fire(
                            '{!! trans('cms::panel.menus.deleted') !!}',
                            '{!! trans('cms::panel.menus.deleted_text') !!}',
                            'success'
                            ).then(function(){
                                location.reload();
                            })
                        }
                    });
                }
                })
        })
    });
  </script>
@endpush

