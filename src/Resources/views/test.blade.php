{{--@if(session('form_errors'))--}}
{{--    @foreach(session('form_errors') as $k => $v)--}}
{{--        {!! trans('cms::panel.'.$v ,['field'=>trans('cms::panel.'.$k)]) !!}<br/>--}}
{{--    @endforeach--}}
{{--@endif--}}
{{--<form enctype="multipart/form-data" method="POST" action="{!! route('form') !!}">--}}
{{--    @csrf--}}
{{--    <input type="hidden" name="form_id" value="1">--}}
{{--    <input type="text" name="email">--}}
{{--    <input type="text" name="name">--}}
{{--    <input type="hidden" name="status" value="">--}}
{{--    <input type="radio" name="status" value="1">--}}
{{--    <input type="radio" name="status" value="0">--}}

{{--    <select name="selectqq">--}}
{{--        <option value="mert">mert</option>--}}
{{--        <option value="aras">aras</option>--}}
{{--        <option value="zeki">zeki</option>--}}
{{--    </select>--}}
{{--    <input type="hidden" name="check" value="15">--}}
{{--    <input type="checkbox" name="check" value="1">--}}
{{--    <input type="file" name="file_image">--}}
{{--    <input type="submit" value="send">--}}
{{--</form>--}}
{{--@php--}}
{{--    auth()->attempt(array('email' => 'tmertc@gmail.com', 'password' => '123456'));--}}
{{--@endphp--}}
@php
    define('C',0);
    define('R',1);
    define('U',2);
    define('D',3);
    $x = decbin(31);
    $b = decbin(15);
    echo bindec("1101");

    echo (15 & (1 << (D))) ? 1:0;

@endphp

<form enctype="multipart/form-data" method="POST" action="{!! route('form') !!}">
    @csrf
    <input type="hidden" name="form_id" value="1">
    <input type="text" name="name" placeholder="name">
    <input type="text" name="email" placeholder="email">
    <input type="file" name="photo" >
    <input type="text" name="country">
    <input type="checkbox" name="checker" value="1">
    <input type="radio" name="radioz" value="0">
    <input type="radio" name="radioz" value="1">
    <select name="selecto">
        <option value="15">15</option>
        <option value="16">onalti</option>
    </select>
    <input type="submit" value="send">
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div id="ebulletin-response"></div>
<input type="text" id="ebulletin-email">
<input type="checkbox" id="ebulletin-check">
<button id="ebulletin-submit">Kaydol</button>
<script>
    $('#ebulletin-submit').click(function () {
        var email = $('#ebulletin-email').val();
        $.ajax('{!! route('ebulletin-store') !!}', {
            type: 'POST',  // http method
            data: {
                _method: 'POST',
                _token: '{{ csrf_token() }}',
                lang_id: '{!! activeLanguage() !!}',
                email: email
            },  // data to submit
            success: function (data, status, xhr) {
                console.log(data);
                $('#ebulletin-response').html("<p>success</p>");
            },
            error: function (jqXhr, textStatus, errorMessage) {
                $('#ebulletin-response').html("");
                $.each(jqXhr.responseJSON.response,function (key,value) {
                    $('#ebulletin-response').append("<p>"+value+"</p>");
                });
            }
        });
    });
</script>
