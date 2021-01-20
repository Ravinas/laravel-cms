@extends('cms::panel.newinc.app')
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
                url:'{!! route('menu.store') !!}',
                method:'post',
                data:$('#menuform').serialize(),
                success:function (response) {
                        if (response.Message == "Ok")
                        {
                            Swal.fire({
                                title: 'Başarılı',
                                text: 'Menü ekleme işleminiz başarı ile gerçekleşti.',
                                icon: 'success',
                                type: 'success'
                            }).then(function(){
                                location.reload();
                            })
                        }
                }
            });
        });

        $('.del').click(function(){
            var id = $(this).attr("data");
            var url =$(this).attr("data-url");
            Swal.fire({
                title: 'Bunu yapmak istediğinize emin misiniz?',
                text: "Bu işlemi geri alamazsınız!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, silmek istiyorum!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:url,
                        method:'DELETE',
                        dataType: "JSON",
                        data: {
                        "menu": id,
                        "_method": 'DELETE'
                        },
                        success:function (response) {
                            Swal.fire(
                            'Silindi!',
                            'Menü tamamen silindi.',
                            'success'
                            ).then(function(){
                                location.reload();
                            })
                        }
                    });
                }
                })
        })
    </script>
@endpush
@section('content')
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>{{ trans('panel.edit_your_menus') }}</h3>
        <p class="text-subtitle text-muted">{{ trans('menu_dont_forgot') }}</p>
    </div>
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class='card-heading p-1 pl-3 float-left'>{{ trans('languages') }}</h3>
                        <button type="button" class="btn icon icon-left btn-primary float-right" data-toggle="modal" data-target="#inlineForm"><i data-feather="edit" ></i> {{ trans('create_menu') }}</button>
                        <div class="form-group">
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
                                    <form id="menuform">
                                    <div class="modal-body">
                                        <label>{{ trans('menu_name') }} </label>
                                        <div class="form-group">
                                        <input type="text" placeholder="Menüyü Adlandırın" class="form-control" name="name">
                                        </div>
                                        <label>{{ trans('select_menu_language') }} </label>
                                        <div class="form-group">
                                        <select class="form-select" id="basicSelect" name="lang">
                                            @foreach($lang as $language)
                                            <option value="{!! $language->id !!}">{!! $language->name !!}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                    </form>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary float-right" id="post">Oluştur</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-5">
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        @foreach ($lang as $lng)
                                        <a class="nav-link {{ $loop->first ? 'active' : '' }} mt-2" id="v-pills-{!! $lng->id !!}-tab" data-toggle="pill" href="#v-pills-{!! $lng->id !!}" role="tab"
                                        aria-controls="{!! $lng->id !!}-tab" aria-selected="true">{!! $lng->name !!}</a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        @foreach ($lang as $lng)
                                            <div class="tab-pane fade {{ $loop->first ? 'active show' : '' }}"  id="v-pills-{!! $lng->id !!}" role="tabpanel" aria-labelledby="v-pills-{!! $lng->id !!}-tab">
                                                @foreach ($lng->menu as $menu)
                                                    <li class="list-group-item d-flex justify-content-end align-items-center">
                                                        <span class="mr-auto p-2">{!! $menu->name !!}</span>
                                                        <a href="{!! route('menu.edit',['menu' => $menu->id ]) !!}" class="btn icon btn-info ml-2"><i data-feather="plus-circle"></i></a>
                                                        <a href="#" class="btn icon btn-danger ml-2 del" data="{{ $menu->id }}" data-url="{!! route('menu.destroy' , ['menu' => $menu->id]) !!}"><i data-feather="delete"></i></a>
                                                    </li>
                                                @endforeach
                                             </div>
                                        @endforeach
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
