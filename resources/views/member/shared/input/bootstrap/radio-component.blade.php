<div class="form-check {{ !empty($inline) ? 'form-check-inline' : '' }}">
    <label class="form-check-label" {{ (!empty($id) ? 'for="' . $id . '"' : '') }}>
        @component('member.shared.input.radio-component', [
            'checked' => (!empty($checked) ? $checked: false)
        ])
            @slot('name') {{ $name }} @endslot
            @slot('class') form-check-input {{ $class or '' }} @endslot
            @slot('autofocus') {{ $autofocus or '' }} @endslot
            @slot('required') {{ $required or '' }} @endslot
            @slot('id') {{ $id or '' }} @endslot
            @slot('value') {{ $value or '' }} @endslot
            @slot('attributes') {{ $attributes or '' }} @endslot
        @endcomponent

        @if ($label)
            {{ $label }}
        @endif
    </label>
</div>