@if ($errors->has($input_name))
    <span class="help-block text-danger">
        <strong>{{ $errors->first($input_name) }}</strong>
    </span>
@endif
