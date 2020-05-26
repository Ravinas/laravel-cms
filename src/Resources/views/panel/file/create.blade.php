@extends('cms::panel.inc.app')
@push('css')

@endpush

@push('js')
@endpush
@section('content')
        <form enctype="multipart/form-data" method="POST" action="{!! route('files.store') !!}">
            @method('POST')
            @csrf
            <div class="form-group page-name">
                <label>Dosya</label>
                <input type="file" class="form-control" id="file" name="file" placeholder="Dosya">
            </div>
            <div class="form-group page-date">
                <input type="submit" class="form-control btn-primary col-3" id="submit" value="Oluştur">
            </div>
        </form>
@endsection
