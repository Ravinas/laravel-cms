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
                    @include('cms::panel.inc.alert')
                    <div class="card">
                        <div class="card-block">
                            <h2 class="card-title">{!! trans('cms::form.forms') !!}</h2>
                            @can('create',CMS\Models\Form::class)
                            <a class="btn-success btn float-right" href="{!! route('forms.create') !!}">{!! trans('cms::form.create') !!}</a>
                            @endcan
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{!! trans('cms::form.id') !!}</th>
                                        <th>{!! trans('cms::form.name') !!}</th>
                                        <th>{!! trans('cms::form.receiver') !!}</th>
                                        <th>{!! trans('cms::form.slug') !!}</th>
                                        <th>{!! trans('cms::form.action') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($forms as $form)
                                    <tr>
                                        <td>{!! $form->id !!}</td>
                                        <td>{!! $form->name !!}</td>
                                        <td>{!! $form->email !!}</td>
                                        <td>{!! $form->slug !!}</td>
                                        <td>
                                            <a href="{!! route('forms.messages.index' , ['form' => $form]) !!}" class="btn waves-effect waves-light btn-success hidden-sm-down">{!! trans('cms::form.messages') !!}</a>
                                            @can('update',$form)
                                            <a href="{!! route('forms.edit' , ['form' => $form]) !!}" class="btn waves-effect waves-light btn-warning hidden-sm-down">{!! trans('cms::form.edit') !!}</a>
                                            @endcan
                                            @can('delete',$form)
                                                @include('cms::panel.inc.delete_modal',['trans_file' => 'form', 'model' => $form, 'route_group' => 'forms', 'route_parameter' => 'form'])
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                {{ $forms->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
