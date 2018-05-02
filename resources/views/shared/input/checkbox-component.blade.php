<input type="checkbox" name="{{ $name }}" class="{{ $class or '' }}"
        {{ $autofocus or '' }}
        {{ $required or '' }}
        {!! isset($id) ? 'id="'.$id.'"' : '' !!}
        {!! isset($value) ? 'value="'.$value.'"' : '' !!}
        {!! $attributes or '' !!}
>