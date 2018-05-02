<input type="file" name="{{ $name }}" class="{{ $class or '' }}"
        {{ $autofocus or '' }}
        {{ $required or '' }}
        {!! isset($id) ? 'id="'.$id.'"' : '' !!}
        {!! $attributes or '' !!}
>