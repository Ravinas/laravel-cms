@extends('cms::panel.inc.app')
@push('css')

@endpush

@push('js')
    <script type="text/javascript">

        var csrf = "{!! csrf_token() !!}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf
            }
        });
        $('#post').click(function (e) {
            e.preventDefault();
            $.ajax({
                url:'{!! route('socialmedia.store') !!}',
                method:'post',
                data:$('#smform').serialize(),
                success:function (response) {
                    if (response.Message == "Ok")
                    {
                        window.location.reload(true);
                    }
                }
            });
        });

        $('.edit').click(function () {
            var id = $(this).attr('sm-id');
            $.ajax({
                url:'{!! route('ajaxEdit') !!}',
                method:'post',
                data:{id:id},
                success:function (response) {
                    console.log(response);
                    $('.editname').val(response.social.name);
                    $('.edit-id').val(response.social.id);
                    $('.editclass').val(response.social.class);
                    $('.editurl').val(response.social.url);
                    $('.editorder').val(response.social.order);
                    $('#editModal').modal('show');

                }
            });
        });

        $('#edit-post').click(function (e) {
            e.preventDefault();
            $.ajax({
                url:'{!! route('ajaxUpdate') !!}',
                method:'post',
                data:$('#editform').serialize(),
                success:function (response) {
                    if (response.Message == "Ok")
                    {
                        window.location.reload(true);
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
                            <h4 class="card-title">{!! trans('cms::panel.sm') !!}</h4>
                            <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">
                                {!! trans('cms::panel.create') !!}
                            </button>
                            <div class="table-responsive"></div>
                            <ul class="list-group">
                                @foreach($sm as $m)
                                    <li class="list-group-item mt-2  justify-content-between bg-light">{!! $m->name  !!}
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="#" sm-id="{!! $m->id !!}" type="button" class="btn-success btn edit">{!! trans('cms::panel.edit') !!}</a>
                                            @include('cms::panel.inc.delete_modal',['trans_file' => 'panel', 'model' => $m, 'route_group' => 'socialmedia', 'route_parameter' => 'socialmedia'])
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{!! trans('panel.create_socialmedia') !!}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <form id="smform">
                            <label>Name</label>
                            <div>
                                <input type="text" class="form-control" autocomplete="off" name="name"/>
                            </div>
                            <label>Class</label>
                            <div>
                                <input type="text" class="form-control" autocomplete="off" name="class"/>
                            </div>
                            <label>Url</label>
                            <div>
                                <input type="text" class="form-control" autocomplete="off" name="url"/>
                            </div>
                            <label>Order</label>
                            <div>
                                <input type="number" class="form-control" autocomplete="off" name="order"/>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{!! trans('panel.close') !!}</button>
                    <button type="button" id="post" class="btn btn-primary">{!! trans('panel.create') !!}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">{!! trans('panel.create_socialmedia') !!}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <form id="editform">
                            <label>Name</label>
                            <div>
                                <input type="text" class="form-control editname" autocomplete="off" name="name" />
                                <input type="hidden" name="id" class="edit-id" />
                            </div>
                            <label>Class</label>
                            <div>
                                <input type="text" class="form-control editclass" autocomplete="off" name="class"/>
                            </div>
                            <label>Url</label>
                            <div>
                                <input type="text" class="form-control editurl" autocomplete="off" name="url"/>
                            </div>
                            <label>Order</label>
                            <div>
                                <input type="number" class="form-control editorder" autocomplete="off" name="order"/>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{!! trans('panel.close') !!}</button>
                    <button type="button" id="edit-post" class="btn btn-primary">{!! trans('panel.create') !!}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
