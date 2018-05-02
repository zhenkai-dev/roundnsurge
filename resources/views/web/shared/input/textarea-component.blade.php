<textarea name="{{ $name }}" class="form-control {{ $class or '' }}"
        {{ $autofocus or '' }}
        {{ $required or '' }}
        {!! isset($id) ? 'id="'.$id.'"' : '' !!}
        {!! $attributes or '' !!}
>{!! $value or '' !!}</textarea>