@extends('cms::panel.inc.app')
@push('css')
    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script src="{!! asset("vendor/cms/js/pageEdit.js") !!}"></script>
    <script>
        var result;
        var files;
        var csrf = "{!! csrf_token() !!}";
        var page = "{!! $page->id !!}";
        var isDetail;
        var fileKey;
        var pageDetail;
        var confirmText = "{!! trans('cms::panel.confirm_text') !!}";
        var imgExtensions = ["jpeg","png","jpg","bmp","svg"];

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrf
            }
        });
        var allEditors = document.querySelectorAll('.ck');
        for (var i = 0; i < allEditors.length; ++i) {
            CKEDITOR.replace(allEditors[i]);
            CKEDITOR.config.allowedContent = true;
        }

        $('.urls').keyup(function (e) {

            var el = $(this);
            var url = el.val();
            var page_id = el.attr('page-id');
            var code = $(this).attr('lang-code');
            var old = $(this).data('old');
            $(this).val($(this).val().toLowerCase()
                .replace(/ı/g,'i')
                .replace(/ö/g,'o')
                .replace(/ç/g,'c')
                .replace(/ş/g,'s')
                .replace(/ü/g,'u')
                .replace(/ğ/g,'g')
                .replace(/ /g,'-')
                .replace('//','/')
                .replace(/[^\w/-]+/g,''));
            if(url != old){
                $(el).parent('.form-group').find('.urls').css("border-color","green");
                $(el).parent('.form-group').find('.result').html( "" );
                $.ajax({
                    url:'{!! route('pages.checkurl') !!}' ,
                    method : 'POST' ,
                    data :{ "_token": "{{ csrf_token() }}", "url" : code+"/"+url ,"page_id" : page_id } ,
                    success:function (response) {
                        if (response.Status)
                        {
                            $(el).parent('.form-group').find('.urls').css("border-color","green");

                        }else {
                            $(el).parent('.form-group').find('.urls').css("border-color","red");
                            $(el).parent('.form-group').find('.result').html( "<div class='alert alert-danger mt-1'>This url is currently in use</div>" );
                        }
                    }
                });
            }

        });

    </script>
@endpush

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-10">
                    <div class="card  mt-3 col-12 bg-light-inverse">
                        <div class="card-block">
                            <form method="POST" action="{!! route('pages.update',array('page'=>$page)) !!}" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf

                                @if($page->page_id)
                                    <input type="hidden" class="form-control" name="page_id" value="{!! $page->page_id !!}">
                                @endif

                            </div>
                        @if(Auth::user()->role_id == 1)
                            <div class="form-group page-status">
                                <label>{!! trans('cms::panel.type') !!}</label>
                                <div>
                                    <select class="custom-select custom-select-lg mb-3" name="type">
                                        <option value="0" @if($page->type == 0) selected @endif>{!! trans('cms::panel.static') !!}</option>
                                        <option value="1" @if($page->type == 1) selected @endif>{!! trans('cms::panel.dynamic') !!}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{!! trans('cms::panel.view') !!}</label>
                                <input type="text" class="form-control" name="view"  placeholder="{!! trans('cms::panel.view') !!}" value="{!! $page->view !!}"/>
                            </div>
                        @endif
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @foreach( $pageDetails as $pd)
                            @if($pd->language)
                            <li class="nav-item">
                                <a class="nav-link {!! $loop->first ? "active" : "" !!}" id="p{!! $pd->id !!}-tab" data-toggle="tab" href="#p{!! $pd->id !!}" role="tab" aria-controls="{!! $pd->id !!}" aria-selected="{!! $loop->first ? "true" : "" !!}" onclick="$('#f{!! $pd->id !!}-tab').click();">{!! $pd->language->name !!}</a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        @foreach($pageDetails as $pd)
                            @if($pd->language)
                                <div class="tab-pane fade  {!! $loop->first ? "show active" : "" !!}" id="p{!! $pd->id !!}" role="tabpanel" aria-labelledby="p{!! $pd->id !!}-tab">
                                    <div class="card">
                                        <div class="card-block">
                                            <div class="form-group">
                                                <input type="checkbox" value="1" class="form-control-user" name="detail_status[{!! $pd->lang_id !!}]" @if($pd->status == 1) checked @endif id="detail_status[{!! $pd->lang_id !!}]"/> <label for="detail_status[{!! $pd->lang_id !!}]">{!! $pd->language->name !!}</label>
                                            </div>
                                            <div id="lang{!! $pd->lang_id !!}" >
                                                <div class="form-group">
                                                    <label>{!! trans('cms::panel.name') !!}</label>
                                                    <input type="text" class="form-control page-name" name="name[{!! $pd->lang_id !!}]" lang-code="{!! '/'.$pd->language->code.'/' !!}" placeholder="{!! trans('cms::panel.name') !!}" value="{!! $pd->name !!}" required/>
                                                </div>
                                                <div class="form-group">
                                                    <label>{!! trans('cms::panel.url') !!}</label>
                                                    <br/>
                                                    <strong>{!! env('APP_URL') !!}/{!! ($pd->showLanguageCode) ? $pd->language->code."/" : "" !!}</strong>
                                                    <input style="width:50%;" type="text" class="form-control urls {!! app()->defaultLanguage == $pd->language ? 'default_lang' : '' !!}"
                                                           lang-code="{!! $pd->language->code !!}"
                                                           page-id="{!! $pd->id !!}"
                                                           name="url[{!! $pd->lang_id !!}]"
                                                           placeholder="{!! trans('cms::panel.url') !!}"
                                                           value="{!! $pd->url !!}"
                                                           data-old="{!! $pd->url !!}"/>
                                                        <div class="result"></div>
                                                    @if(session('error'))
                                                        <div class="alert alert-danger mt-1">
                                                            This url is already in use.
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="form-group">
                                                    <label>{!! trans('cms::panel.content') !!}</label>
                                                    <textarea class="form-control ck"  cols="50" rows="10" name="content[{!! $pd->lang_id !!}]" placeholder="{!! trans('cms::panel.content') !!}">{!! $pd->content !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if($include)
                            @include($include)
                        @endif

                    </div>
                        <div class="form-group page-status col-sm-5 float-left">
                            <label>{!! trans('cms::panel.status') !!}</label>
                            <div>
                                <input type="radio" id="ac" value="1" class="form-control-user" name="status" @if($page->status) checked @endif> <label  for="ac">{!! trans('cms::panel.active') !!}</label>
                            </div>
                            <div>
                                <input type="radio" value="0" id="ps" class="form-control-user" name="status" @if(!$page->status) checked @endif> <label  for="ps">{!! trans('cms::panel.passive') !!}</label>
                            </div>
                        </div>


                    <div class="form-group page-date">
                        <input type="submit" class="btn btn-success " id="submit" value="{!! trans('cms::panel.update') !!}">
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="filemanager" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sunucudaki Resimler</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row files">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="file" id="file-input" name="file-input">

                    <button type="button" class="btn btn-primary file-save">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
