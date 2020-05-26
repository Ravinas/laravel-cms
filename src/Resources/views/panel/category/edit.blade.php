@extends('cms::panel.inc.app')
@push('css')
    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
        }
    </style>
@endpush

@push('js')
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            @include('cms::panel.inc.breadcrumb')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <form method="POST" action="{!! route('categories.store') !!}" enctype="multipart/form-data">
                                @method('POST')
                                @csrf
                                <div class="form-group page-status col-lg-2 float-left ml-4">
                                    <label>{!! trans('cms::panel.type') !!}</label>
                                    <div>
                                        <select class="custom-select custom-select-lg mb-3" name="parent_id">
                                            <option value="0">Parent</option>
                                            @foreach($categories as $category)
                                                <option value="{!! $category->id !!}">{!! $category->name !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-2 float-left ml-4">
                                            <label>{!! trans('cms::panel.order') !!}</label>
                                            <input type="number" id="ac" class="form-control" name="order" value="{!! $page->order !!}"/>
                                </div>
                                <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                <div class="form-group col-4 float-left ml-4">
                                    <label>Category Picture</label>
                                    <input type="file" class="form-control" name="picture"/>
                                    <button type="button" class="btn btn-primary col-12 mt-1" data-toggle="modal" data-target="#exampleModalCenter">
                                        Choose File
                                    </button>
                                </div>
                                <div class="form-group page-status col-lg-2 float-left ml-4">
                                    <label>{!! trans('cms::panel.status') !!}</label>
                                    <div>
                                        <input type="radio" id="ac" value="1" class="form-control" name="status" > <label for="ac">{!! trans('cms::panel.active') !!}</label>
                                    </div>
                                    <div>
                                        <input type="radio" value="0" id="ps" class="form-control" name="status" checked> <label for="ps">{!! trans('cms::panel.passive') !!}</label>
                                    </div>
                                </div>
                        </div>
                            </div>
                                <div class="form-group page-language">
                                    @foreach( lang() as $l)
                                        <div class="card">
                                            <div class="card-block">
                                                <div class="form-group">
                                                    <input type="checkbox" id="{!! $l->id  !!}" value="1" class="form-control-user" name="detail_status[{!! $l->id !!}]" checked /> <label for="{!! $l->id !!}">{!! $l->name !!}</label>
                                                </div>
                                                <div id="lang{!! $l !!}" >
                                                    <div class="form-group">
                                                        <label>{!! trans('cms::category.name') !!}</label>
                                                        <input type="text" class="form-control page-name"  name="name[{!! $l->id !!}]" placeholder="{!!trans('cms::category.name') !!}"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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
    <div class="modal" tabindex="-1" id="exampleModalCenter" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sunucudaki Resimler</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(isset($files))
                    @foreach($files as $file)
                        <div class="form-group float-left">
                            <input type="radio" class="ajax_image" id="{!! $file->id !!}" name="file_id" value="{!! $file->id !!}">
                            <label  for="{!! $file->id !!}"></label>
                            <img src="{!! asset("/storage/".$file->path) !!}" style="width: 50px;height:50px;"/>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary ajax_post">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
