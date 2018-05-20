<div class="input-group">
    @if (!empty($addonLeft))
        <div class="input-group-prepend">
            <span class="input-group-text">{{ $addonLeft }}</span>
        </div>
    @endif
    @component('member.shared.input.text-component')
        @slot('type') {{ $type }} @endslot
        @slot('name') {{ $name }} @endslot
        @slot('id') {{ $id or '' }} @endslot
        @slot('value') {{ $value or '' }} @endslot
        @slot('required') {{ $required or '' }} @endslot
        @slot('autofocus') {{ $autofocus or '' }} @endslot
        @slot('attributes') {{ $attributes or '' }} @endslot
    @endcomponent
    @if (!empty($addonRight))
        <div class="input-group-append">
            <span class="input-group-text">{{ $addonRight }}</span>
        </div>
    @endif
</div>