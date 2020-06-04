@extends('panel.inc.app')
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
                url:'{!! route('slider.store') !!}',
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
                            <h4 class="card-title">{!! trans('panel.menu') !!}</h4>
                            <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">
                                {!! trans('panel.create') !!}
                            </button>
                            <div class="table-responsive"></div>
                            <ul class="list-group">
                                @foreach($slider as $s)
                                    <li class="list-group-item mt-2  justify-content-between bg-light">{!! $s->name  !!}
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{!! route('slider.edit',['slider' => $s->id ]) !!}" type="button" class="btn-success btn">{!! trans('panel.images') !!}</a>
                                            @include('panel.inc.delete_modal',['trans_file' => 'panel', 'model' => $s, 'route_group' => 'slider', 'route_parameter' => 'slider'])
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
                    <h5 class="modal-title" id="exampleModalLabel">Create Menu</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <form id="menuform">
                            <label>Name</label>
                            <div>
                                <input type="text" class="form-control" autocomplete="off" name="name"/>
                            </div>
                            <label>Language</label>
                            <div>
                                <select class="custom-select custom-select-lg mb-3" name="lang">
                                    @foreach($lang as $language)
                                        <option value="{!! $language->id !!}">{!! $language->name !!}</option>
                                    @endforeach
                                </select>
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
    <!-- Toast -->
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <img src="..." class="rounded mr-2" alt="...">
            <strong class="mr-auto">Bootstrap</strong>
            <small>11 mins ago</small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            Hello, world! This is a toast message.
        </div>
    </div>
@endsection
