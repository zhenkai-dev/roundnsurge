@component('admin.shared.input.select-component')
    @slot('name') {{ $name }} @endslot
    @slot('option')
        <option value="1" selected>{{ __('common.active') }}</option>
        <option value="0" {{ $value == '0' ? 'selected' : '' }}>{{ __('common.disabled') }}</option>
    @endslot
    @slot('id') {{ $id or '' }} @endslot
    @slot('required') {{ $required or '' }} @endslot
    @slot('autofocus') {{ $autofocus or '' }} @endslot
    @slot('attributes') {{ $attributes or '' }} @endslot
@endcomponent