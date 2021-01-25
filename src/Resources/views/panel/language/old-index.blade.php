@extends('cms::panel.inc.app')
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            @include('cms::panel.inc.breadcrumb')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-block">
                            <form action="{!! route('languages.update' , ['language' => 1]) !!}" method="post">
                                @method('PUT')
                                @csrf
                            <label>{!! trans('cms::panel.default_language') !!}</label>
                            <div>
                                <select class="custom-select custom-select-lg mb-3" name="def_lang_id">
                                    @if($default_language)
                                    <option value="{!! $default_language->id !!}" selected>{!! $default_language->name !!}</option>
                                    @endif
                                    @foreach($active_languages as $language)
                                        <option value="{!! $language->id !!}">{!! $language->name !!}</option>
                                    @endforeach
                                </select>
                            </div>
                                <div class="form-group m-3">
                                    <input type="submit" class="btn btn-success float-right" id="submit" value="{!! trans('cms::panel.update') !!}">
                                </div>
                                <label>{!! trans('cms::panel.active_languages') !!}</label>s
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{!! trans('cms::panel.status') !!}</th>
                                        <th>{!! trans('cms::panel.name') !!}</th>
                                        <th>{!! trans('cms::panel.slug') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if($default_language)
                                        <tr>
                                            <td><input type="checkbox" id="{!! $default_language->name !!}" checked name="langs[{!! $default_language->id !!}]" value="{!! $default_language->id !!}"><label for="{!! $default_language->name !!}"></label></td>
                                            <td>{!! $default_language->name !!}</td>
                                            <td>{!! $default_language->code !!}</td>
                                        </tr>
                                        @endif
                                    @foreach($active_languages as $language)
                                        <tr>
                                            <td><input type="checkbox" id="{!! $language->name !!}" checked name="langs[{!! $language->id !!}]" value="{!! $language->id !!}"><label for="{!! $language->name !!}"></label></td>
                                            <td>{!! $language->name !!}</td>
                                            <td>{!! $language->code !!}</td>
                                        </tr>
                                    @endforeach
                                    @foreach($passive_languages as $language)
                                        <tr>
                                            <td><input type="checkbox" id="{!! $language->name !!}" name="langs[{!! $language->id !!}]" value="{!! $language->id !!}"><label for="{!! $language->name !!}"></label></td>
                                            <td>{!! $language->name !!}</td>
                                            <td>{!! $language->code !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group m-3">
                                    <input type="submit" class="btn btn-success float-right" id="submit" value="{!! trans('cms::panel.update') !!}">
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
