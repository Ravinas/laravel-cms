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
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">{!! trans('cms::panel.pages') !!}</h4>
                            <a class="btn-success btn float-right" href="{!! route('pages.create',['page' => $parent_id]).'&type=dynamic' !!}">{!! trans('cms::panel.create') !!}</a>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{!! trans('cms::panel.id') !!}</th>
                                        <th>{!! trans('cms::panel.name') !!}</th>
                                        <th>{!! trans('cms::panel.url') !!}</th>
                                        <th>{!! trans('cms::panel.action') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sub_pages as $page)
                                        <tr>
                                            <form action="{!! route('pages.destroy' , ['page' => $page]) !!}" method="post" onsubmit="return confirm('Are you sure you want to submit this form?');">
                                                @method('DELETE')
                                                @csrf
                                            <td>{!! $page->id !!}</td>
                                            <td>{!! $page->name !!}</td>
                                            <td>{!! $page->url !!}</td>
                                            <td><a href="{!! route('pages.edit' , ['page' => $page->id]).'?type=dynamic' !!}" class="btn waves-effect waves-light btn-warning hidden-sm-down">{!! trans('cms::panel.edit') !!}</a>
                                                @if($page->type)
                                                    <a href="{!! route('subpages' , ['id' => $page->id]) !!}" class="btn waves-effect waves-light btn-success hidden-sm-down ml-1">{!! trans('cms::panel.sub_pages') !!}</a>
                                                @endif
                                                <button type="submit" class="btn waves-effect waves-light btn-danger hidden-sm-down ml-1">{!! trans('cms::panel.delete') !!}</button>
                                            </td>
                                            </form>
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
@endsection
