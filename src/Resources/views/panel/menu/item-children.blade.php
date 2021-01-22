<ol>
    @foreach ($childs as $children)
    <li class="mt-1" id="menuItem-{{ $children->id}}" style="list-style: none;">
        <div class="list-group-item d-flex justify-content-end align-items-center">
          <span class="mr-auto p-2">{!!  $children->text !!}</span>
          <a href="{!! route('delete-item',['menuitem' => $item->id]) !!}" class="btn icon btn-info ml-2" data-id="{!! $item->id !!}"><i data-feather="plus-circle"></i></a>
          <a href="#" class="btn icon btn-danger ml-2 del" data="{{ $menu->id }}" data-url="{!! route('delete-item',['menuitem' => $children->id]) !!}"><i data-feather="delete"></i></a>
        </div>
        @if($children->children)
           @include('cms::panel.menu.new-item-children',['childs' => $children->children])
        @endif
    </li>
    @endforeach
</ol>
