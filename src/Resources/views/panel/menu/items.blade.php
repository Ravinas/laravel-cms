@extends('panel.inc.app')
@push('js')
<script src="http://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
<script type="text/javascript" src="{!! asset('js/jquery.mjs.nestedSortable.js') !!} "></script>
<script type="text/javascript">
     $('ol.sortable').nestedSortable({
        handle: 'div.menu-handle',
        helper: 'clone',
        items: 'li',
        opacity: .6,
        revert: 250,
        tabSize: 25,
        maxLevels:3,
        tolerance: 'pointer',
        toleranceElement: '> div',
        isTree: true,
    });
            $("#serialize").click(function(e) {
                 e.preventDefault();
                var serialized = $('ol.sortable').nestedSortable('serialize');
 
                $.ajax({
                url: "{{ route('menuajax') }}",
                method: "POST",
                data: {sort: serialized,_token: '{{csrf_token()}}'},
                success: function(res) {
                    $('.alert').show();
                    $('.alert').hide(3000);
                }
                });
            });


     var csrf = "{!! csrf_token() !!}";
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': csrf
         }
     });
     $('#post').click(function (e) {
         e.preventDefault();
         $.ajax({
             url:'{!! route('menuitemajax') !!}',
             method:'post',
             data:$('#menuform').serialize(),
             success:function (response) {
                 if (response.Message == "Ok")
                 {
                     window.location.reload(true);
                 }
             }
         });
     });
</script>


@endpush
@push('css')
<style>
    ol {
    list-style-type: none;
    }
    
    .menu-handle {
    padding: 15px;
    border-radius: 3px;
    border: 2px solid #26c6da;
    font-size: 15px;
    margin-bottom: 10px;
        line-height: 30px;
    }
    
    .menu-options {
        float: right;
    }
    </style>
@endpush
@section('content')

@php

   

@endphp

<div class="page-wrapper">
    <div class="container-fluid">
        @include('cms::panel.inc.breadcrumb')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-block">
                        <h4 class="card-title">{!! trans('panel.items') !!}</h4>
                        <ol class="sortable">
                            @foreach($menu_items as $item)
                            <li id="menuItem-{{$item->id}}">
                                <div class="menu-handle">
                                    <span>
                                        {!! $item->text !!}
                                    </span>
                                <div class="menu-options">
                                    <a class="btn-danger btn float-right" data-id="{!! $item->id !!}" href="{!! route('delete-item',['menuitem' => $item->id]) !!}">{!! trans('panel.delete') !!}</a>
                                </div>
                                </div>
                            @if($item->children)
                            @include('panel.menu.item-children',['childs' => $item->children])
                            @endif
                            @endforeach
                            </li>
                            </ol>
                            <button type="button" class="btn btn-warning float-right" data-toggle="modal" data-target="#exampleModal">{!! trans('panel.add') !!}</button>
                            <button type="button" class="btn btn-success float-right mr-3" id="serialize">{!! trans('panel.update') !!}</button>
                    </div>
                    <div class="alert alert-success hide" role="alert">
                        Saved
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <form id="menuform">
                                <label>Type</label>
                                <div>
                                    <select class="custom-select custom-select-lg mb-3" name="type">
                                        <option value="1">Single</option>
                                        <option value="2">Dropdown</option>
                                    </select>
                                </div>
                                <input type="hidden" name="menu_id" value="{!! $menu->id !!}">
                                <label>Title</label>
                                <div>
                                    <input type="text" class="form-control" autocomplete="off" name="text"/>
                                </div>
                                <label>Link</label>
                                <div>
                                    <input type="text" class="form-control" autocomplete="off" name="link"/>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="post" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </div>
        </div>


@endsection