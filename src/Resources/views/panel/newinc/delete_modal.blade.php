<button type="button" class="btn btn-danger icon" data-toggle="modal" data-target="#delete_{!! $route_group !!}_{!! $model->id !!}">
    <i data-feather="trash-2"></i> {{ trans('cms::panel.delete_modal.button') }}
</button>
<form action="{!! route($route_group.'.destroy' , $model) !!}" method="POST" class="pull-right">
@method('DELETE')
@csrf
<!-- Modal -->
    <div class="modal fade" id="delete_{!! $route_group !!}_{!! $model->id !!}" tabindex="-1" role="dialog" aria-labelledby="delete_{!! $route_group !!}_Label{!! $model->id !!}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete_{!! $route_group !!}_Label{!! $model->id !!}">{{ trans('cms::panel.delete_modal.title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ $slot }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{!! trans('cms::panel.delete_modal.no') !!}</button>
                    <button type="submit" class="btn btn-danger">{!! trans('cms::panel.delete_modal.yes') !!}</button>
                </div>
            </div>
        </div>
    </div>
</form>
