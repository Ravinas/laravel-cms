@extends('cms::panel.newinc.app')
@push('css')

@endpush

@push('js')
    <script>

        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
@endpush
@section('content')

    <div class="main-content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-content">
                    <div class="card-body">
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.forms.title') }}</div>
                        </div>
                        <div class="alert alert-secondary">
                            <i data-feather="info"></i>{{ trans('cms::panel.forms.info') }}
                        </div>
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.forms.list') }}</div>

                            <div class="form-group">
                                @can('create',CMS\Models\Form::class)
                                    <a class="btn icon icon-left btn-primary float-right" href="{!! route('forms.create') !!}"><i data-feather="plus-circle" ></i>{!! trans('cms::panel.forms.create') !!}</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class='table table-hover' id="myTable">
                                        <thead >
                                        <tr>
                                            <th>{!! trans('cms::panel.forms.id') !!}</th>
                                            <th>{!! trans('cms::panel.forms.name') !!}</th>
                                            <th>{!! trans('cms::panel.forms.receiver') !!}</th>
                                            <th>{!! trans('cms::panel.forms.slug') !!}</th>
                                            <th>{!! trans('cms::panel.forms.action') !!}</th>
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
                                                    <a href="{!! route('forms.messages.index' , $form) !!}" class="btn btn-success icon"><i data-feather="mail" ></i> {!! trans('cms::panel.forms.messages') !!}</a>
                                                    <a href="{!! route('forms.edit' ,  $form) !!}" class="btn btn-warning icon"><i data-feather="edit" ></i> {!! trans('cms::panel.forms.edit') !!}</a>

                                                    @component('cms::panel.newinc.delete_modal',[ 'model' => $form, 'route_group' => 'forms'])
                                                        {!! trans('cms::panel.forms.delete_text') !!}
                                                    @endcomponent
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
