@extends('cms::panel.newinc.app')
@push('css')
<link rel="stylesheet" href="{!! asset('vendor/cms/yeni/vendors/choices.js/choices.min.css') !!}">
@endpush
@section('content')

<div class="main-content container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="card-content">
                <div class="card-body">
                    <div class="divider">
                        <div class="divider-text">{!! $page->detail->name !!}</div>
                    </div>
                    <div class="alert alert-secondary">
                        <i data-feather="info"></i>{{ trans('cms::panel.edit_page') }}
                    </div>
                    <div class="divider">
                        <div class="divider-text">{{ trans('cms::panel.settings') }}</div>
                    </div>
                    <div class="row">
                        <form method="POST" action="{!! route('pages.update',array('page'=>$page)) !!}" enctype="multipart/form-data" novalidate>
                            @method('PUT')
                            @csrf
                            <div class="row justify-content-end">
                                <div class="from-group">
                                    <div class="form-check form-switch  float-right">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" name="status" value="1"  {!! $page->status == 1 ? 'checked' : '' !!}>
                                        <label class="form-check-label" for="flexSwitchCheckDefault">{!! trans('cms::panel.page_isactive') !!}</label>
                                    </div>
                                </div>
                            </div>
                            @if($page->page_id)
                                    <input type="hidden" class="form-control" name="page_id" value="{!! $page->page_id !!}">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <label>{!! trans('cms::panel.categories') !!}</label>
                                            <div class="form-group">
                                                <select class="choices form-select multiple-remove" multiple="multiple" name="category[]">
                                                    @foreach ($categories as $category)
                                                    <option value="{!! $category->id !!}" {!! in_array($category->id,$page_categories) ? 'selected' : '' !!}>{!! $category->detail->name !!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <label>{!! trans('cms::panel.order') !!}</label>
                                            <div class="form-group">
                                                <select class="choices form-select" name="order">
                                                    @for($order;$order != 0;$order --)
                                                    <option value="{!! $order !!}" {!! $order == $page->order ? 'selected' : '' !!}>{!! $order !!}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                            @endif
                            @if(Auth::user()->role_id == 1)
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <label>Sayfa Tipi </label>
                                    <div class="form-group">
                                        <select class="form-select" id="basicSelect" name="type">
                                            <option value="0" {!! $page->type == 0 ? 'selected' : '' !!}>{!! trans('cms::panel.static') !!}</option>
                                            <option value="1" {!! $page->type == 1 ? 'selected' : ''!!}>{!! trans('cms::panel.dynamic') !!}</option>
                                            <option value="2" {!! $page->type == 2 ? 'selected' : ''!!}>{!! trans('cms::panel.homepage') !!}</option>
                                            <option value="3" {!! $page->type == 3 ? 'selected' : ''!!}>{!! trans('cms::panel.search') !!}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <label>{!! trans('cms::panel.blade_file') !!}</label>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="view">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="divider">
                        <div class="divider-text">{!! trans('cms::panel.content') !!}</div>
                    </div>
                    <div class="row">
                        <div class="row">
                            <div class="col-3">
                                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    @foreach ($pageDetails as $pd)
                                        @if ($pd->language)
                                            <a class="nav-link  {!! $loop->first ? 'active' : '' !!}" id="p{!! $pd->id !!}-tab" data-toggle="pill" href="#v{!! $pd->id !!}" role="tab"
                                            aria-controls="{!! $pd->id !!}" aria-selected="{!! $loop->first ? "true" : "" !!}">{!! $pd->language->name !!}</a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="tab-content" id="v-pills-tabContent">
                                    @foreach ($pageDetails as $pd)
                                        @if ($pd->language)
                                        <div class="tab-pane fade {!! $loop->first ? 'show active' : '' !!}" id="v{!! $pd->id !!}" role="tabpanel" aria-labelledby="{!! $pd->id !!}-tab">
                                            <div class="form-group">
                                                <label>{!! trans('cms::panel.page_title') !!}</label>
                                                <input type="text" class="form-control page-name" name="name[{!! $pd->lang_id !!}]" lang-code="{!! '/'.$pd->language->code.'/' !!}" placeholder="{!! trans('cms::panel.name') !!}" value="{!! $pd->name !!}" required/>
                                            </div>
                                            <div class="form-group">
                                                <label>{!! trans('cms::panel.url') !!}</label>
                                                <br/>
                                                <strong>{!! env('APP_URL') !!}{!! ($pd->showLanguageCode) ? $pd->language->code."/" : "" !!}</strong>
                                                <input  type="text" class="form-control urls {!! app()->defaultLanguage == $pd->language ? 'default_lang' : '' !!}"
                                                       lang-code="{!! $pd->language->code !!}"
                                                       page-id="{!! $pd->id !!}"
                                                       name="url[{!! $pd->lang_id !!}]"
                                                       placeholder="{!! trans('cms::panel.url') !!}"
                                                       value="{!! $pd->url !!}"
                                                       data-old="{!! $pd->url !!}"/>
                                                    <div class="result"></div>
                                                    <div class="form-group mt-1">
                                                        <label>{!! trans('cms::panel.content') !!}</label>
                                                        <textarea class="form-control ck"  cols="50" rows="10" name="content[{!! $pd->lang_id !!}]" placeholder="{!! trans('cms::panel.content') !!}">{!! $pd->content !!}</textarea>
                                                    </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                    @if($include)
                                        @include($include)
                                    @endif
                                </div>
                                <div class="form-group page-date">
                                    <input type="submit" class="btn btn-primary " id="submit" value="{!! trans('cms::panel.update') !!}">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script src="{!! asset('vendor/cms/yeni/vendors/choices.js/choices.min.js') !!}"></script>
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script src="{!! asset('vendor/cms/js/pageEdit.js') !!}"></script>
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
