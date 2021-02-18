<ol>
    @foreach ($childs as $children)
        <li class="mt-1" id="categoryItem-{{ $children->id}}" style="list-style: none;">
            <div class="list-group-item d-flex justify-content-end align-items-center">
                                        <span class="mr-auto">
                                            {!! ucfirst($children->detail->name)  !!}
                                        </span>
                <button class="btn icon btn-info ml-2 edit" data-id="{!! $children->id !!}" data-toggle="modal" data-target="#edit_modal"><i data-feather="edit" ></i></button>
                @component('cms::panel.newinc.delete_modal',[ 'model' => $category, 'route_group' => 'categories'])
                    {!! trans('cms::panel.categories.delete_text') !!}
                @endcomponent
            </div>
        </li>
        @if($children->childrens)
            @include('cms::panel.category.children',['childs' => $children->childrens])
        @endif
    @endforeach
</ol>
