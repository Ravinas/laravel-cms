@foreach($childs as $child)
    <li class="list-group-item mt-2  justify-content-between" style="margin-left:{!! $margin !!}px;">{!! $child->detail->name.">".$child->id !!}
         <div class="btn-group" role="group" aria-label="Basic example">
              <a href="{!! route('categories.edit',['category' => $child->id ]) !!}" type="button" class="btn-success btn">{!! trans('cms::panel.edit') !!}</a>
             @include('cms::panel.inc.delete_modal',['trans_file' => 'category', 'model' => $category, 'route_group' => 'categories', 'route_parameter' => 'category'])
        </div>
    </li>
    @if(count($child->childrens))
		@include('cms::panel.category.treeView',['childs' => $child->childrens , 'margin' => $margin + 20])
    @endif
@endforeach
