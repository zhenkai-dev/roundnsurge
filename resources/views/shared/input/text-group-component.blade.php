<div class="input-group">
    <div class="input-group-prepend">
        <span class="input-group-text">{{ $addonLeft }}</span>
    </div>
    @component('admin.shared.input.text-component')
        @slot('type') {{ $type }} @endslot
        @slot('name') {{ $name }} @endslot
        @slot('id') {{ $id or '' }} @endslot
        @slot('value') {{ $value or '' }} @endslot
        @slot('required') {{ $required or '' }} @endslot
        @slot('autofocus') {{ $autofocus or '' }} @endslot
        @slot('attributes') {{ $attributes or '' }} @endslot
    @endcomponent
</div>