@extends('cms::panel.newinc.app')
@section('content')
<div class="main-content container-fluid">
    <div class="divider">
        <div class="divider-text">{!! Str::ucfirst($slider->name)  !!}</div>
    </div>
    <div class="alert alert-secondary">
        <i data-feather="info"></i>{{ trans('cms::panel.menu_items_info') }}
    </div>
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class='card-heading p-1 pl-3 float-left'>{!! trans('cms::panel.items') !!}</h3>
                        <button type="button" class="btn icon icon-left btn-primary float-right" data-toggle="modal" data-target="#inlineForm"><i data-feather="plus-circle" ></i>{{ trans('cms::panel.add') }}</button>
                        <button type="button" id="send_list" class="btn icon icon-left btn-warning float-right mr-2" style="display: none"><i data-feather="check-circle" ></i>{!! trans('cms::panel.save_changes') !!}</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <ol class="sortable" style="list-style: none;">
                                @foreach ($images as $image)
                                <li class="mt-1" id="sliderItem-{{$image->id}}" style="list-style: none;">
                                    <div class="list-group-item d-flex justify-content-end align-items-center">
                                        <span class="mr-auto">
                                            @if ($image->filepath)
                                            <img style="max-height:100px;max-width: 100px;" src="{!! $image->filepath !!}"/>
                                            @else
                                            <img style="max-height:100px;max-width: 100px;" src="{{ asset('/vendor/cms/images/default-image.png') }}"/>
                                            @endif
                                        </span>
                                        <span class="mr-auto">{{ Str::ucfirst($image->general_text)  }}</span>
                                      <button class="btn icon btn-info ml-2 edit_image" data-id="{!! $image->id !!}" data-toggle="modal" data-target="#edit_modal"><i data-feather="edit" ></i></button>
                                      <a href="#" class="btn icon btn-danger ml-2 del" data-url="{!! route('delimage') !!}" data-id="{!! $image->id !!}" ><i data-feather="delete"></i></a>
                                    </div>
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
<div class="form-group">
    <!--Modal -->
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel33">{{ trans('panel.create_menu_item') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i data-feather="x"></i>
            </button>
            </div>
            <form id="menuform">
            <input type="hidden" name="slider_id" value="{!! $slider->id !!}">
            <div class="modal-body">
                <label>Text</label>
                <div class="form-group">
                    <input type="text" class="form-control" autocomplete="off" name="general_text"/>
                </div>
                <input type="hidden" name="slider" value="{!! $slider->id !!}"/>

                <label>Text</label>
                <div class="form-group">
                    <input type="text" class="form-control" autocomplete="off" name="sub_text"/>
                </div>
                <label>Text</label>
                <div class="form-group">
                    <input type="text" class="form-control" autocomplete="off" name="sub_text2"/>
                </div>
                <label>Image</label>
                <div class="form-group">
                <div class="input-group">
                <span class="input-group-btn">
                    <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-success">
                    <i class="fa fa-picture-o"></i> Choose
                    </a>
                </span>
                    <input id="thumbnail" class="form-control" type="text" name="filepath">
                </div>
                <img id="holder" style="margin-top:15px;max-height:100px;">
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
    <div class="modal fade text-left" id="edit_modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel33">{{ trans('panel.create_menu_item') }} </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i data-feather="x"></i>
            </button>
            </div>
            <form id="menuform">
            <input type="hidden" name="slider_id" value="{!! $slider->id !!}">
            <div class="modal-body">
                <label>Text</label>
                <div class="form-group">
                    <input type="text" class="form-control edit_general_text" autocomplete="off" name="edit_general_text"/>
                </div>
                <input type="hidden" name="slider" value="{!! $slider->id !!}"/>

                <label>Text</label>
                <div class="form-group">
                    <input type="text" class="form-control edit_sub_text" autocomplete="off" name="edit_sub_text"/>
                </div>
                <label>Text</label>
                <div class="form-group">
                    <input type="text" class="form-control edit_sub_text2" autocomplete="off" name="edit_sub_text2"/>
                </div>
                <label>Image</label>
                <div class="form-group">
                <div class="input-group">
                <span class="input-group-btn">
                    <a id="lfm2" data-input="thumbnail2" data-preview="holder2" class="btn btn-success">
                    <i class="fa fa-picture-o"></i> Choose
                    </a>
                </span>
                    <input id="thumbnail2" class="form-control edit_filepath" type="text" name="filepath">
                </div>
                <img id="holder2" style="margin-top:15px;max-height:100px;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
                <i class="bx bx-check d-block d-sm-none"></i>
                <span class="d-none d-sm-block" id="edit_post">{{ trans('cms::panel.edit') }}</span>
                </button>
            </div>
            </form>
        </div>
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
            maxLevels:'1',
            stop:function(){
                $('#send_list').removeClass().addClass("btn icon icon-left btn-warning float-right mr-2");
                $('#send_list').show();
            }
        });


        $('#send_list').click(function(){
            var serialized = $('ol.sortable').nestedSortable('serialize');
            $.ajax({
            url: "{{ route('sortImage') }}",
            method: "POST",
            data: {sort: serialized,_token: '{{csrf_token()}}'},
                success: function(res) {
                    $('#send_list').removeClass().addClass("btn icon icon-left btn-success float-right mr-2").html("Changes Saved").fadeOut(3000);
                    console.log("İşlem Başarılı");
                }
            });
        });

        //Slider değişikliklierinin kaydedilmesi..
        $('#edit_post').click(function () {
            var data = {};
            data.id = $('.edit_image').val();
            data.order = $('.edit_order').val();
            data.general_text =  $('.edit_general_text').val();
            data.sub_text = $('.edit_sub_text').val();
            data.sub_text2 = $('.edit_sub_text2').val();
            data.filepath = $('.edit_filepath').val();
            $.ajax({
                url:'{!! route('editImage') !!}',
                method:'post',
                data:{data:data},
                success:function (response) {
                    if (response.Message == "Ok")
                    {
                        $('#editModal').modal("hide");
                        Swal.fire({
                            title: 'Done!',
                            text: 'Değişiklikler başarıyla kaydedildi!',
                            icon: 'success',
                            confirmButtonText: 'Teşekkürler',
                        }).then((result)  => {
                            window.location.reload(true);
                        });

                    }
                }
            });
        });

        //Yeni bir sliderın eklenmesi..
        $('#post').click(function (e) {
         e.preventDefault();

         $.ajax({
             url:'{!! route('addImage') !!}',
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

        //Edit modalının doldurulması..
        $('.edit_image').click(function () {
            var id = $(this).attr('data-id');
            $.ajax({
               url:'{!! route('getSliderImage') !!}',
               method:'post',
               data:{id:id},
               success:function (response) {
                    console.log(response.Slider);
                   $('.edit_image').val(response.Slider.id);
                   $('.edit_order').val(response.Slider.order);
                   $('.edit_general_text').val(response.Slider.general_text);
                   $('.edit_sub_text').val(response.Slider.sub_text);
                   $('.edit_sub_text2').val(response.Slider.sub_text2);
                   $('#thumbnail2').val(response.Slider.filepath);
               }
            });
        });

        $('.del').click(function(){
            var id = $(this).attr("data-id");
            var url =$(this).attr("data-url");

            Swal.fire({
                title: 'Bunu yapmak istediğinize emin misiniz?',
                text: "Resim sliderdan silinecek!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, silmek istiyorum!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:url,
                        method:'POST',
                        dataType: "JSON",
                        data: {
                        "image": id
                        },
                        success:function (response) {
                            Swal.fire(
                            'Başarıyla Silindi!',
                            'Slider silindi.',
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

