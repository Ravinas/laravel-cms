@extends('cms::panel.inc.app')
@push('css')
    <style>
        .ck-editor__editable_inline {
            min-height: 400px;
        }
    </style>
@endpush

@push('js')
    <script type="text/javascript">
        $('.custom-select').change(function(){
            var parent_id = $(this).val();
            $.ajax({
                url:'{!! route('categories.order') !!}',
                method:'POST',
                data:{"_token": "{{ csrf_token() }}",parent_id},
                success:function(data){
                    $('#order').html("");
                    if (data.orders.length < 1) {
                        $('#order').append('<option value="1">"1"</option>');
                    }
                    $.each(data.orders, function(key,value){
                        $('#order').append('<option value='+value+'>'+value+'</option>');
                    });
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
                                    <div>
                                            <select class="custom-select custom-select-lg mb-3 order" id="order" name="order">
                                                    <option value="{!! $order !!}">{!! $order !!}</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="form-group col-4 float-left ml-4">
                                    <label>Category Picture</label>
                                    <input type="file" class="form-control" name="picture"/>
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
                                                        <input type="text" class="form-control page-name"  name="name[{!! $l->id !!}]" placeholder="{!!trans('cms::category.name') !!}" required />
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
@endsection
