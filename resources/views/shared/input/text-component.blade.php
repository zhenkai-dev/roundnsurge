<input type="{{ $type }}" name="{{ $name }}" class="form-control {{ $class or '' }}"
        {{ $autofocus or '' }}
        {{ $required or '' }}
        {!! isset($id) ? 'id="'.$id.'"' : '' !!}
        {!! isset($value) ? 'value="'.$value.'"' : '' !!}
        {!! $attributes or '' !!}
>