@extends('cms::panel.newinc.app')
@push('css')

@endpush

@push('js')
@endpush

@section('content')

    <div class="main-content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-content">
                    <div class="card-body">
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.roles.edit') }}</div>
                        </div>
                        <div class="alert alert-secondary">
                            <i data-feather="info"></i>{{ trans('cms::panel.roles.editinfo') }}
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form method="POST" action="{!! route('roles.update',array('role'=>$role)) !!}">
                                    @method('PUT')

                                    @csrf

                                    <div class="form-group">
                                        <label>{!! trans('cms::panel.roles.name') !!}</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{!! $role->name !!}">
                                        @include('cms::panel.inc.form_error',['input_name' => 'name'])
                                    </div>
                                    <div>
                                        <h2>{!! trans('cms::panel.roles.module_permissions') !!}</h2>
                                        @foreach($modules as $module)

                                            <div class="form-group">
                                                <label><strong>{!! trans('cms::panel.roles.module_'.$module->name) !!}</strong></label>
                                                <div>
                                                    <input type="checkbox" class="form-check-input" id="module[{!! $module->id !!}]_create" name="module[{!! $module->id !!}][]" value="C" {{ $role->hasModulePermission($module->id,'C') ? 'checked' : '' }}>
                                                    <label for="module[{!! $module->id !!}]_create">{!! trans('cms::panel.roles.crud_create') !!}</label>
                                                    <input type="checkbox" class="form-check-input" id="module[{!! $module->id !!}]_read" name="module[{!! $module->id !!}][]" value="R" {{ $role->hasModulePermission($module->id,'R') ? 'checked' : '' }}>
                                                    <label for="module[{!! $module->id !!}]_read">{!! trans('cms::panel.roles.crud_read') !!}</label>
                                                    <input type="checkbox" class="form-check-input" id="module[{!! $module->id !!}]_update" name="module[{!! $module->id !!}][]" value="U" {{ $role->hasModulePermission($module->id,'U') ? 'checked' : '' }}>
                                                    <label for="module[{!! $module->id !!}]_update">{!! trans('cms::panel.roles.crud_update') !!}</label>
                                                    <input type="checkbox" class="form-check-input" id="module[{!! $module->id !!}]_delete" name="module[{!! $module->id !!}][]" value="D" {{ $role->hasModulePermission($module->id,'D') ? 'checked' : '' }}>
                                                    <label for="module[{!! $module->id !!}]_delete">{!! trans('cms::panel.roles.crud_delete') !!}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <hr>
                                    <div>
                                        <h2>{!! trans('cms::panel.roles.page_permissions') !!}</h2>
                                        @foreach($pages as $page)
                                            <div class="form-group">
                                                <label>{!! $page->name !!}</label>
                                                <div>
                                                    <input type="checkbox" class="form-check-input" id="page[{!! $page->id !!}]_create" name="page[{!! $page->id !!}][]" value="C" {{ $role->hasPagePermission($page->id,'C') ? 'checked' : '' }}>
                                                    <label for="page[{!! $page->id !!}]_create">{!! trans('cms::panel.roles.crud_create') !!}</label>
                                                    <input type="checkbox" class="form-check-input" id="page[{!! $page->id !!}]_read" name="page[{!! $page->id !!}][]" value="R" {{ $role->hasPagePermission($page->id,'R') ? 'checked' : '' }}>
                                                    <label for="page[{!! $page->id !!}]_read">{!! trans('cms::panel.roles.crud_read') !!}</label>
                                                    <input type="checkbox" class="form-check-input" id="page[{!! $page->id !!}]_update" name="page[{!! $page->id !!}][]" value="U" {{ $role->hasPagePermission($page->id,'U') ? 'checked' : '' }}>
                                                    <label for="page[{!! $page->id !!}]_update">{!! trans('cms::panel.roles.crud_update') !!}</label>
                                                    <input type="checkbox" class="form-check-input" id="page[{!! $page->id !!}]_delete" name="page[{!! $page->id !!}][]" value="D" {{ $role->hasPagePermission($page->id,'D') ? 'checked' : '' }}>
                                                    <label for="page[{!! $page->id !!}]_delete">{!! trans('cms::panel.roles.crud_delete') !!}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="form-group page-date">
                                        <input type="submit" class="form-control btn-primary col-3" id="submit" value="{!! trans('cms::panel.roles.edit') !!}">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
