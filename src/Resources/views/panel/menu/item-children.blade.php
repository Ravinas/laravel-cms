<ol>
    @foreach($childs as $children)
        <li id="menuItem-{{ $children->id}}" class="mjs-nestedSortable-branch mjs-nestedSortable-expanded">
            <div class="menu-handle">
                                        <span>
                                            {!!  $children->text !!}
                                        </span>
                <div class="menu-options">
                    <a class="btn-danger btn float-right" data-id="{!! $item->id !!}" href="{!! route('delete-item',['menuitem' => $children->id]) !!}">{!! trans('panel.delete') !!}</a>
                </div>
            </div>
            @if($children->children)
                @include('panel.menu.item-children',['childs' => $children->children])
            @endif
        </li>
    @endforeach
</ol>