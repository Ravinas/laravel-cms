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
                            <h2 class="card-title">{!! trans('cms::ebulletin.ebulletins') !!}</h2>
{{--                            <a class="btn-success btn" href="{!! route('forms.create') !!}">{!! trans('cms::panel.form_create') !!}</a>--}}
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{!! trans('cms::ebulletin.id') !!}</th>
                                        <th>{!! trans('cms::ebulletin.email') !!}</th>
                                        <th>{!! trans('cms::ebulletin.language') !!}</th>
                                        <th>{!! trans('cms::ebulletin.status') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($ebulletins as $e)
                                    <tr>
                                        <td>{!! $e->id !!}</td>
                                        <td>{!! $e->email !!}</td>
                                        <td>{!! $e->name !!}</td>
                                        @if($e->status)
                                        <td class="text-success">{!! trans('cms::ebulletin.active') !!}</td>
                                        @else
                                        <td class="text-disabled font-italic">{!! trans('cms::ebulletin.passive') !!}</td>
                                        @endif
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                {{ $ebulletins->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
