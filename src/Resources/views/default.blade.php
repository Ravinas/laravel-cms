
@extends('cms::website.app')
@section('content')
    <br/>
    araspress
    <br/>

    sayfa ismi: {!! $page->detail->name !!}
    <br/>
    sayfa içeriği: {!! $page->detail->content !!}
    <img src="{!! $page->detail->getImage('aras') !!}" >
    <br/>
@endsection
