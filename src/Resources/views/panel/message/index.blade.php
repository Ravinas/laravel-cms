@extends('cms::panel.inc.app')
@push('css')

@endpush

@push('js')
<script>

    $(document).ready( function () {
        $('#tbl').DataTable();
    } );
    </script>
@endpush
@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            @include('cms::panel.inc.breadcrumb')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <h2 class="card-title">"{!! $form->name !!}" {!! trans('cms::form.messages') !!}</h2>
                            <div class="table-responsive" id="tbl">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>{!! trans('cms::form.id') !!}</th>
                                        <th>{!! trans('cms::form.email') !!}</th>
                                        <th>{!! trans('cms::form.ip') !!}</th>
                                        <th>{!! trans('cms::form.action') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($messages as $message)
                                        @php
                                            $decode = json_decode($message->data,true);
                                            $message->email = $decode["email"];
                                        @endphp
                                    <tr>
                                        <td>{!! $message->id !!}</td>
                                        <td>{!! $message->email !!}</td>
                                        <td>{!! $message->ip !!}</td>
                                        <td><a href="{!! route('messages.show' , ['message' => $message]) !!}" class="btn waves-effect waves-light btn-warning hidden-sm-down">{!! trans('cms::form.show') !!}</a></td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                {{ $messages->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
