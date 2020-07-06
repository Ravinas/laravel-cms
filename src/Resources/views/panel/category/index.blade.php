@extends('cms::panel.inc.app')
@push('css')

@endpush

@push('js')

@endpush
@php($margin = 20)
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            @include('cms::panel.inc.breadcrumb')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">{!! trans('cms::panel.categories') !!}</h4>
                            <a class="btn-success btn float-right" href="{!! route('categories.create') !!}">{!! trans('cms::panel.create') !!}</a>
                            <div class="table-responsive"></div>
                            <ul class="list-group">
                             @foreach($categories as $category)
                                 <li class="list-group-item mt-2  justify-content-between bg-light">{!! $category->name  !!}
                                     <div class="btn-group" role="group" aria-label="Basic example">
                                          <a href="{!! route('categories.edit',['category' => $category->id ]) !!}" type="button" class="btn-success btn">{!! trans('cms::panel.edit') !!}</a>
                                          @include('cms::panel.inc.delete_modal',['trans_file' => 'category', 'model' => $category, 'route_group' => 'categories', 'route_parameter' => 'category'])
                                    </div>
                                </li>
                                 @if(count($category->childrens))
                                    @include('cms::panel.category.treeView',['childs' => $category->childrens,'margin' => $margin])
                                 @endif
                             @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
