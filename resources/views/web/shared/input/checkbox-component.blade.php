<input type="checkbox" name="{{ $name }}" class="{{ $class or '' }}"
        {{ $autofocus or '' }}
        {{ $required or '' }}
        {{ (!empty($checked) && $checked == true ? 'checked="checked"' : '') }}
        {!! isset($id) ? 'id="'.$id.'"' : '' !!}
        {!! isset($value) ? 'value="'.$value.'"' : '' !!}
        {!! $attributes or '' !!}

>