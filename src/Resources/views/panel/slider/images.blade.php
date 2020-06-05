@extends('cms::panel.inc.app')
@push('css')
    <link rel="stylesheet" href="sweetalert2.min.css">
@endpush

@push('js')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="sweetalert2.all.min.js"></script>
    <script type="text/javascript">
        $('#lfm').filemanager('image');
        $('#lft').filemanager('image');
        var csrf = "{!! csrf_token() !!}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf
            }
        });
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

        $('.del').click(function (e) {
            if (window.confirm("Are you sure?"))
            {
                e.preventDefault();
                $.ajax({
                    url:'{!! route('delimage') !!}',
                    method:'post',
                    data:{image:$(this).attr('slider')},
                    success:function () {
                        if (response.Message == "Ok")
                        {
                            window.location.reload(true);
                        }
                    }
                })
            }
        });

        $('.editimage').click(function () {
            var id = $(this).attr('id');
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
                   $('.edit_filepath').val(response.Slider.filepath);
               }
            });
        });

        $('.editim').click(function () {

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
                            text: 'Your changes succesfuly saved',
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        });
                    }
                }
            });
        });
    </script>
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            @include('cms::panel.inc.breadcrumb')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">{!! trans('cms::panel.menu') !!}</h4>
                            <div class="form-group m-3">
                                <input type="submit" class="btn btn-success float-right mb-3" data-toggle="modal" data-target="#exampleModal" id="submit" value="{!! trans('cms::panel.create') !!}">
                            </div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <td>Image</td>
                                    <td>Text</td>
                                    <td>Status</td>
                                    <td>#</td>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($images as $image)
                                    <tr>
                                        <td><img  style="max-height:100px;max-width: 100px;" src="{!! $image->filepath !!}"/></td>
                                        <td>{!! $image->general_text !!}</td>
                                        @if($image->status == 1)
                                            <td>Active</td>
                                        @else
                                            <td>Passive</td>
                                        @endif
                                        <td>
                                            <input type="button" class="btn btn-danger float-right mb-3 del"  slider="{!! $image->id !!}" value="{!! trans('cms::panel.delete') !!}">
                                            <input type="button" class="btn btn-warning float-right mb-3 mr-2 editimage"  id="{!! $image->id !!}" value="{!! trans('cms::panel.edit') !!}" data-toggle="modal" data-target="#editModal">
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

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <form id="menuform">
                                <label>Order</label>
                                <div>
                                    <input type="number" class="form-control" autocomplete="off" name="order"/>
                                    <input type="hidden" name="slider" value="{!! $slider->id !!}"/>
                                </div>
                                <label>Text</label>
                                <div>
                                    <input type="text" class="form-control" autocomplete="off" name="general_text"/>
                                </div>
                                <label>Text</label>
                                <div>
                                    <input type="text" class="form-control" autocomplete="off" name="sub_text"/>
                                </div>
                                <label>Text</label>
                                <div>
                                    <input type="text" class="form-control" autocomplete="off" name="sub_text2"/>
                                </div>
                                <label>Image</label>
                                <div>
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
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="post" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal">Create Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <form id="edit">
                                <label>Order</label>
                                <div>
                                    <input type="number" class="form-control edit_order" autocomplete="off" name="edit_order"/>
                                    <input type="hidden" name="edit_image" class="edit_image"/>
                                </div>
                                <label>Text</label>
                                <div>
                                    <input type="text" class="form-control edit_general_text" autocomplete="off" name="edit_general_text"/>
                                </div>
                                <label>Text</label>
                                <div>
                                    <input type="text" class="form-control edit_sub_text" autocomplete="off" name="edit_sub_text"/>
                                </div>
                                <label>Text</label>
                                <div>
                                    <input type="text" class="form-control edit_sub_text2" autocomplete="off" name="edit_sub_text2"/>
                                </div>
                                <label>Image</label>
                                <div>
                                    <div class="input-group">
                                           <span class="input-group-btn">
                                             <a id="lft" data-input="thumbnailx" data-preview="holder" class="btn btn-success">
                                               <i class="fa fa-picture-o"></i> Choose
                                             </a>
                                           </span>
                                        <input id="thumbnailx" class="form-control edit_filepath" type="text" name="edit_filepath">
                                    </div>
                                    <img id="holder" style="margin-top:15px;max-height:100px;">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                        <button type="button" class="editim" class="btn btn-success">{!! trans('panel.update') !!}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
