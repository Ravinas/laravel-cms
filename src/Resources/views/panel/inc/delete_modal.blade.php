<button type="button" class="btn icon btn-danger ml-2" data-toggle="modal" data-target="#delete_{!! $route_parameter !!}_{!! $model->id !!}">
    <i data-feather="delete"></i>
</button>
<form action="{!! route($route_group.'.destroy' , [$route_parameter => $model]) !!}" method="POST" class="pull-right">
@method('DELETE')
@csrf
<!-- Modal -->
    <div class="modal fade" id="delete_{!! $route_parameter !!}_{!! $model->id !!}" tabindex="-1" role="dialog" aria-labelledby="delete_{!! $route_parameter !!}_Label{!! $model->id !!}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete_{!! $route_parameter !!}_Label{!! $model->id !!}">{!! trans($trans_file.'.delete_modal_title') !!}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! trans($trans_file.'.delete_modal_body') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{!! trans($trans_file.'.delete_no') !!}</button>
                    <button type="submit" class="btn btn-danger">{!! trans($trans_file.'.delete_yes') !!}</button>
                </div>
            </div>
        </div>
    </div>
</form>
