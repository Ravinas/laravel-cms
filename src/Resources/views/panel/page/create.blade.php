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
    <script type="text/javascript" src="{!! asset('/vendor/cms/js/ckfinder/ckfinder.js') !!}"></script>
    <script>CKFinder.config( { connectorPath: '/ckfinder/connector' } );</script>

    <script>

   var allEditors = document.querySelectorAll('.ck');
    for (var i = 0; i < allEditors.length; ++i) {
        var editor = CKEDITOR.replace(allEditors[i]);
        CKFinder.setupCKEditor( editor );
    }



    //Page ismi yazıldığında url inputuna uygun şekilde url oluşturur ve arkaplanda kontrolunu sağlar..

    $('.page-name').keyup(function () {
        $(this).parent('.form-group').next().find('.result').html( "" );
        var lang_code = $(this).attr('lang-code');
        var parent_url = $(this).attr('parent-url');
        text = $(this).val();
        var slug = text.toLowerCase()
            .replace(/ı/g,'i')
            .replace(/ö/g,'o')
            .replace(/ç/g,'c')
            .replace(/ş/g,'s')
            .replace(/ü/g,'u')
            .replace(/ğ/g,'g')
            .replace(/ /g,'-')
            .replace(/[^\w-]+/g,'');
        if (parent_url)
        {
            $(this).parent('.form-group').next().find('.urls').val(slug);
        }else
        {
            $(this).parent('.form-group').next().find('.urls').val(slug);
        }

        var el = $(this);
        var url = $(this).parent('.form-group').next().find('.urls').val();
        if (url)
        {
            $.ajax({
                url:'{!! route('pages.checkurl') !!}' ,
                method : 'POST' ,
                data :{ "_token": "{{ csrf_token() }}", "url" : url } ,
                success:function (response) {
                    if (response.Status)
                    {
                        $(el).parent('.form-group').next().find('.urls').css("border-color","green");
                    }else {
                        $(el).parent('.form-group').next().find('.urls').css("border-color","red");
                        $(el).parent('.form-group').next().find('.result').html( "<div class='alert alert-danger mt-1'>This url is currently use</div>" );
                    }
                }
            });
        }
    });

   $('.urls').keyup(function (e) {

       var el = $(this);
       var url = el.val();
       var page_id = el.attr('page-id');
       var code = $(this).attr('lang-code');
       $(el).parent('.form-group').find('.urls').css("border-color","green");
       $(el).parent('.form-group').find('.result').html( "" );
       $.ajax({
           url:'{!! route('pages.checkurl') !!}' ,
           method : 'POST' ,
           data :{ "_token": "{{ csrf_token() }}", "url" : code+"/"+url ,"page_id" : page_id } ,
           success:function (response) {
               if (response.status)
               {
                   alert(1);
                   $(el).parent('.form-group').find('.urls').css("border-color","green");

               }else {
                   $(el).parent('.form-group').find('.urls').css("border-color","red");
                   $(el).parent('.form-group').find('.result').html( "<div class='alert alert-danger mt-1'>This url is currently in use</div>" );
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
                            <h1 class="card-title">
                                <div class="form-group page-status">
                                @if($type)
                                    {!! trans('cms::page.creating_subpage',['parent' => $parent->detail->name ]) !!}
                                @else
                                    {!! trans('cms::page.creating_page') !!}
                                @endif
                                </div>
                            </h1>
                            <form method="POST" action="{!! route('pages.store') !!}">
                                @method('POST')
                                @csrf
                                @if($type)
                                    <input type="hidden" name="page_id" value="{!! $parent->id !!}">
                                @endif
                                @if(Auth::user()->role_id == 1)
                                    <div class="form-group page-status col-lg-2">
                                        <label>{!! trans('cms::panel.type') !!}</label>
                                        <div>
                                            <select class="custom-select custom-select-lg mb-3" name="type">
                                                <option value="0">{!! trans('cms::panel.static') !!}</option>
                                                <option value="1">{!! trans('cms::panel.dynamic') !!}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.view') !!}</label>

                                        <input type="text" class="form-control page-name" name="name[{!! $l->id !!}]" lang-code="{!! '/'.$l->code.'/' !!}" placeholder="{!! trans('cms::panel.name') !!}"  required/>
                                    </div>
                                @endif

                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    @foreach( \CMS\Facades\LanguageFacade::all() as $l)
                                            <li class="nav-item">
                                                <a class="nav-link {!! $loop->first ? "active" : "" !!}" id="p{!! $loop->index !!}-tab" data-toggle="tab" href="#p{!! $loop->index !!}" role="tab" aria-controls="{!! $loop->index !!}" aria-selected="{!! $loop->first ? "true" : "" !!}">{!! $l->name !!}</a>
                                            </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    @foreach( \CMS\Facades\LanguageFacade::all() as $l)
                                            <div class="tab-pane fade  {!! $loop->first ? "show active" : "" !!}" id="p{!! $loop->index !!}" role="tabpanel" aria-labelledby="p{!! $loop->index !!}-tab">
                                                <div class="card">
                                                    <div class="card-block">
                                                        <div class="form-group">
                                                            <input type="checkbox" value="1" class="form-control-user" name="detail_status[{!! $l->id !!}]" checked id="detail_status[{!! $l->id !!}]"/> <label for="detail_status[{!! $l->id !!}]">{!! $l->name !!}</label>
                                                        </div>
                                                        <div id="lang{!! $l->id !!}" >
                                                            <div class="form-group">
                                                                <label>{!! trans('cms::panel.name') !!}</label>

                                                                <input type="text" class="form-control page-name" name="name[{!! $l->id !!}]" lang-code="{!! '/'.$l->code.'/' !!}" placeholder="{!! trans('cms::panel.name') !!}"  required/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{!! trans('cms::panel.url') !!}</label>
                                                                <br/>
                                                                <input type="text" class="form-control" id="domain" value="{!! env('APP_URL') !!}/{!! $l->code !!}/" disabled style="width:20%;min-width:200px;"/>
                                                                <input style="width:79%;" type="text" class="form-control urls {!! \CMS\Facades\LanguageFacade::isDefault($l->id) ? 'default_lang' : '' !!}" lang-code="{!! $l->code !!}"  name="url[{!! $l->id !!}]" placeholder="{!! trans('cms::panel.url') !!}" required/>
                                                                <div class="result"></div>
                                                                @if(session('error'))
                                                                    <div class="alert alert-danger mt-1">
                                                                        This url is already in use.
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{!! trans('cms::panel.content') !!}</label>
                                                                <textarea class="form-control ck"  cols="50" rows="10" name="content[{!! $l->id !!}]" placeholder="{!! trans('cms::panel.content') !!}"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                    @endforeach
                                </div>
                                <div class="form-group page-status col-lg-2">
                                    <label>{!! trans('cms::panel.status') !!}</label>
                                    <div>
                                        <input type="radio" id="ac" value="1" class="form-control" name="status" > <label for="ac">{!! trans('cms::panel.active') !!}</label>
                                    </div>
                                    <div>
                                        <input type="radio" value="0" id="ps" class="form-control" name="status" checked> <label for="ps">{!! trans('cms::panel.passive') !!}</label>
                                    </div>
                                </div>
                                <div class="form-group page-date">
                                    <input type="submit" class="btn btn-success float-right" id="submit" value="{!! trans('cms::panel.create') !!}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
