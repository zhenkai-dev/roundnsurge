<select name="{{ $name }}" class="form-control {{ $class or '' }}"
        {{ $autofocus or '' }}
        {{ $required or '' }}
        {!! isset($id) ? 'id="'.$id.'"' : '' !!}
        {!! $attributes or '' !!}
>
    {!! $option !!}
</select>