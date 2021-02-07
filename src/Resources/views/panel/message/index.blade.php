@extends('cms::panel.newinc.app')
@push('css')

@endpush

@push('js')
    <script>

        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
@endpush
@section('content')

    <div class="main-content container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-content">
                    <div class="card-body">
                        <div class="divider">
                            <div class="divider-text">{{ $form->name." ".trans('cms::panel.messages.title') }}</div>
                        </div>
                        <div class="alert alert-secondary">
                            <i data-feather="info"></i>{{ trans('cms::panel.messages.info') }}
                        </div>
                        <div class="divider">
                            <div class="divider-text">{{ trans('cms::panel.messages.list') }}</div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class='table table-hover' id="myTable">
                                        <thead >
                                        <tr>
                                            <th>{!! trans('cms::panel.messages.id') !!}</th>
                                            <th>{!! trans('cms::panel.messages.email') !!}</th>
                                            <th>{!! trans('cms::panel.messages.ip') !!}</th>
                                            <th>{!! trans('cms::panel.messages.action') !!}</th>
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
                                                <td><a href="{!! route('messages.show' ,$message ) !!}" class="btn btn-info icon"><i data-feather="mail" > </i> {!! trans('cms::panel.messages.show') !!}</a></td>
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
    </div>
@endsection
