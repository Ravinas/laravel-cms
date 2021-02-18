@extends('cms::panel.newinc.app')
@section('content')
    <div class="main-content container-fluid">
        <section class="section">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="divider">
                                <div class="divider-text">{!! trans('cms::panel.categories')  !!}</div>
                            </div>
                            <div class="alert alert-secondary">
                                <i data-feather="info"></i>{{ trans('cms::panel.menu_items_info') }}
                            </div>
                            <button type="button" class="btn icon icon-left btn-primary float-right" data-toggle="modal" data-target="#inlineForm"><i data-feather="plus-circle" ></i>{{ trans('cms::panel.add') }}</button>
                            <button type="button" id="send_list" class="btn icon icon-left btn-warning float-right mr-2" style="display: none"><i data-feather="check-circle" ></i>{!! trans('cms::panel.save_changes') !!}</button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <ol class="sortable" style="list-style: none;">
                                    @foreach($categories as $category)
                                        <li class="mt-1" id="categoryItem-{{$category->id}}" style="list-style: none;">
                                            <div class="list-group-item d-flex justify-content-end align-items-center">
                                        <span class="mr-auto">
                                            {!! ucfirst($category->detail->name)  !!}
                                        </span>
                                                <button class="btn icon btn-info ml-2 edit" data-id="{!! $category->id !!}" data-toggle="modal" data-target="#edit_modal"><i data-feather="edit" ></i></button>
                                                @include('cms::panel.inc.delete_modal',['trans_file' => 'category', 'model' => $category, 'route_group' => 'categories', 'route_parameter' => 'category'])
                                            </div>
                                            @if($category->childrens)
                                                @include('cms::panel.category.children',['childs' => $category->childrens])
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

    <!-- Modal -->
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">{!! trans('cms::panel.create') !!} </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="categoryform">
                    <div class="modal-body">
                        <div class="from-group">
                            <div class="form-check form-switch  float-right">
                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="status" value="1" checked>
                                <label class="form-check-label" for="flexSwitchCheckDefault">{!! trans('cms::panel.category_ison') !!}</label>
                            </div>
                        </div>
                        <label>{{ trans('cms::panel.category_type') }} </label>
                        <div class="form-group">
                            <select class="choices form-select" name="parent_id">
                                <option value="0">{!! trans('cms::panel.main_category') !!}</option>
                                <optgroup label="{!! trans('cms::panel.sub_category_for') !!}">
                                    @foreach($categories as $category)
                                        <option value="{!! $category->id !!}">{!! $category->name !!}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <label>{!! trans('cms::panel.image') !!}</label>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                    <i class="fa fa-picture-o"></i> {!! trans('cms::panel.choose') !!}
                                    </a>
                                </span>
                                <input id="thumbnail" class="form-control edit_filepath" type="text" name="picture">
                            </div>
                            <img id="holder" style="margin-top:15px;max-height:100px;">
                        </div>
                        @foreach(app()->activeLanguages as $language)
                            <div class="from-group">
                                <div class="form-check form-switch  float-right">
                                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="detail_status[{!! $language->id !!}]" value="1" checked>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">{!! trans('cms::panel.category_ison') !!}</label>
                                </div>
                            </div>
                            <label>{!! $language->name !!} {{ trans('cms::panel.category_name') }} </label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="name[{!! $language->id !!}]" autocomplete="none" required>
                            </div>
                        @endforeach

                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary float-right" id="post">Oluştur</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade text-left" id="edit_modal" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">{!! trans('cms::panel.update') !!} </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form id="editform" method="post" action="{!! route('update-category') !!}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="from-group">
                            <div class="form-check form-switch  float-right">
                                <input class="form-check-input" type="checkbox" id="edit_status" name="edit_status" value="1">
                                <label class="form-check-label" for="flexSwitchCheckDefault">{!! trans('cms::panel.category_ison') !!}</label>
                            </div>
                        </div>
                        <input type="hidden" id="edit_id" name="edit_id"/>
                        <label>{{ trans('cms::panel.category_type') }} </label>
                        <div class="form-group">
                            <select class="choices form-select" name="edit_parent_id" id="edit_parent_id">
                                <option value="0">{!! trans('cms::panel.main_category') !!}</option>
                                <optgroup label="{!! trans('cms::panel.sub_category_for') !!}">
                                    @foreach($categories as $category)
                                        <option value="{!! $category->id !!}">{!! $category->name !!}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <label>{!! trans('cms::panel.image') !!}</label>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-primary">
                                    <i class="fa fa-picture-o"></i> {!! trans('cms::panel.choose') !!}
                                    </a>
                                </span>
                                <input id="thumbnail2" class="form-control edit_image" type="text" name="edit_picture">
                            </div>
                            <img id="holder2" style="margin-top:15px;max-height:100px;">
                        </div>
                        @foreach(app()->activeLanguages as $language)
                            <div class="from-group">
                                <div class="form-check form-switch  float-right">
                                    <input class="form-check-input " type="checkbox" id="edit_detail_status-{!! $language->id !!}" name="edit_detail_status[{!! $language->id !!}]" value="1">
                                    <label class="form-check-label" for="{!! $language->id !!}">{!! trans('cms::panel.category_ison') !!}</label>
                                </div>
                            </div>
                            <label>{!! $language->name !!} {{ trans('cms::panel.category_name') }} </label>
                            <div class="form-group">
                                <input type="text" id="edit_name-{!! $language->id !!}" class="form-control" name="edit_name[{!! $language->id !!}]" autocomplete="none" required>
                            </div>
                        @endforeach

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary float-right">{!! trans('cms::panel.update') !!}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{!! asset('vendor/cms/js/jquery.mjs.nestedSortable.js') !!}"></script>
    <script>
        $(document).ready(function(){

            $('#lfm').filemanager('image');
            $('#lfm2').filemanager('image');

            var csrf = "{!! csrf_token() !!}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrf
                }
            });

            $('ol.sortable').nestedSortable({
                handle: 'div',
                items: 'li',
                toleranceElement: '> div',
                stop:function(){
                    $('#send_list').removeClass().addClass("btn icon icon-left btn-warning float-right mr-2");
                    $('#send_list').val('Değişiklikleri Kaydedin');
                    $('#send_list').show();
                }
            });


            $('#send_list').click(function(){
                var serialized = $('ol.sortable').nestedSortable('serialize');
                $.ajax({
                    url: "{{ route('sort-category') }}",
                    method: "POST",
                    data: {sort: serialized,_token: '{{csrf_token()}}'},
                    success: function(res) {
                        $('#send_list').removeClass().addClass("btn icon icon-left btn-success float-right mr-2").html("Changes Saved").fadeOut(3000);
                        console.log("İşlem Başarılı");
                    }
                });
            });

            //Yeni bir kategorinin eklenmesi..
            $('#post').click(function (e) {
                e.preventDefault();

                $.ajax({
                    url:'{!! route('categories.store')!!}',
                    method:'post',
                    data:$('#categoryform').serialize(),
                    success:function (response) {
                        if (response.Message == "Ok")
                        {
                            window.location.reload(true);
                        }
                    }
                });
            });

            //Edit modalının doldurulması..
            $('.edit').click(function () {
                var id = $(this).attr('data-id');
                $.ajax({
                    url:'{!! route('get-category') !!}',
                    method:'post',
                    data:{id:id},
                    success:function (response) {
                        var details = response.Data.details;
                        $('#edit_id').val(response.Data.id);
                        $('#edit_parent_id option[value='+response.Data.parent_id+']').attr('selected','selected');
                        if (response.Data.status == 1)
                        {
                            $('#edit_status').prop('checked', true);
                        }

                        $('#thumbnail2').val(response.Data.image);
                        Object.keys(response.Data.details).forEach(function (key)
                        {
                            console.log(details[key].lang_id);
                            if (details[key].status == 1)
                            {
                                $('#edit_detail_status-'+details[key].lang_id).prop('checked', true);
                            }
                            $('#edit_name-'+details[key].lang_id).val(details[key].name);
                        });
                    }
                });
            });
        });
    </script>
@endpush

