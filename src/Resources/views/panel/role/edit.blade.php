@extends('cms::panel.inc.app')
@push('css')

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
                            <form method="POST" action="{!! route('roles.update',array('role'=>$role)) !!}">
                                @method('PUT')

                                @csrf

                                <div class="form-group">
                                    <label>{!! trans('cms::role.name') !!}</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="{!! trans('cms::role.name') !!}" value="{!! $role->name !!}">
{{--                        --}}@include('cms::panel.inc.form_error',['input_name' => 'name'])
                                </div>
                                <div>
                                    <h2>{!! trans('cms::role.module_permissions') !!}</h2>
{{--                            --}}@foreach($modules as $module)
                                        <div class="form-group">
                                            <label><strong>{!! trans('cms::role.module_'.$module->name) !!}</strong></label>
                                            <div>
                                                <input type="checkbox" class="form-control" id="module[{!! $module->id !!}]_create" name="module[{!! $module->id !!}][]" value="C" {{ $role->hasModulePermission($module->id,'C') ? 'checked' : '' }}>
                                                <label for="module[{!! $module->id !!}]_create">{!! trans('cms::role.create') !!}</label>
                                                <input type="checkbox" class="form-control" id="module[{!! $module->id !!}]_read" name="module[{!! $module->id !!}][]" value="R" {{ $role->hasModulePermission($module->id,'R') ? 'checked' : '' }}>
                                                <label for="module[{!! $module->id !!}]_read">{!! trans('cms::role.read') !!}</label>
                                                <input type="checkbox" class="form-control" id="module[{!! $module->id !!}]_update" name="module[{!! $module->id !!}][]" value="U" {{ $role->hasModulePermission($module->id,'U') ? 'checked' : '' }}>
                                                <label for="module[{!! $module->id !!}]_update">{!! trans('cms::role.update') !!}</label>
                                                <input type="checkbox" class="form-control" id="module[{!! $module->id !!}]_delete" name="module[{!! $module->id !!}][]" value="D" {{ $role->hasModulePermission($module->id,'D') ? 'checked' : '' }}>
                                                <label for="module[{!! $module->id !!}]_delete">{!! trans('cms::role.delete') !!}</label>
                                            </div>
                                        </div>
{{--                            --}}@endforeach
                                </div>
                                <hr>
                                <div>
                                    <h2>{!! trans('cms::role.page_permissions') !!}</h2>
{{--                                --}}@foreach($pages as $page)
                                        <div class="form-group">
                                            <label>{!! $page->name !!}</label>
                                            <div>
                                                <input type="checkbox" class="form-control" id="page[{!! $page->id !!}]_create" name="page[{!! $page->id !!}][]" value="C" {{ $role->hasPagePermission($page->id,'C') ? 'checked' : '' }}>
                                                <label for="page[{!! $page->id !!}]_create">{!! trans('cms::role.create') !!}</label>
                                                <input type="checkbox" class="form-control" id="page[{!! $page->id !!}]_read" name="page[{!! $page->id !!}][]" value="R" {{ $role->hasPagePermission($page->id,'R') ? 'checked' : '' }}>
                                                <label for="page[{!! $page->id !!}]_read">{!! trans('cms::role.read') !!}</label>
                                                <input type="checkbox" class="form-control" id="page[{!! $page->id !!}]_update" name="page[{!! $page->id !!}][]" value="U" {{ $role->hasPagePermission($page->id,'U') ? 'checked' : '' }}>
                                                <label for="page[{!! $page->id !!}]_update">{!! trans('cms::role.update') !!}</label>
                                                <input type="checkbox" class="form-control" id="page[{!! $page->id !!}]_delete" name="page[{!! $page->id !!}][]" value="D" {{ $role->hasPagePermission($page->id,'D') ? 'checked' : '' }}>
                                                <label for="page[{!! $page->id !!}]_delete">{!! trans('cms::role.delete') !!}</label>
                                            </div>
                                        </div>
{{--                                --}}@endforeach
                                </div>
                                <div class="form-group page-date">
                                    <input type="submit" class="form-control btn-primary col-3" id="submit" value="{!! trans('cms::role.edit') !!}">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
