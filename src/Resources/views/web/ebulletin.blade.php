
<form action="{!! route('ebulletin.save') !!}" method="post" class="{!! $formClass??'' !!}" id="ebulletin">
    @csrf
    <input type="hidden" name="{!! app()->currentLanguage->code !!}">
    <input type="email" name="email">
    {!! $slot !!}
</form>
