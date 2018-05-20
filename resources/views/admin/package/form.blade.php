@extends('admin.layouts.app-form')

@section('heading')
    {!! $title !!}
@endsection

@section('form')

    @php /* @var \App\Package $package */ @endphp
    @php /* @var \App\PackageTranslation $packageTranslation */ @endphp
    <form class="form-horizontal form-validation" action="{{ is_create() ? route('admin.package.store') : route('admin.package.update', $package->id) }}" method="post" enctype="multipart/form-data">
        @if (is_edit())
            {{ method_field('PATCH') }}
        @endif

        {{ csrf_field() }}

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('package.name') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') name @endslot
                    @slot('value') {{ old('name', (is_edit() ? $packageTranslation->getName() : '')) }} @endslot
                    @slot('required') required @endslot
                    @slot('autofocus') autofocus @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('package.price') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-group-component')
                    @slot('addonLeft') {{ currency()->getCurrency()['symbol'] }} @endslot
                    @slot('type') number @endslot
                    @slot('name') price @endslot
                    @slot('value') {{ $package->getPrice() }} @endslot
                    @slot('required') required @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('package.description') }} @endslot
            @slot('input')
                @component('admin.shared.input.textarea-component')
                    @slot('id') description @endslot
                    @slot('class') autosize @endslot
                    @slot('name') description @endslot
                    @slot('value') {{ old('description', (is_edit() ? $packageTranslation->getDescription() : '')) }} @endslot
                @endcomponent
            @endslot
        @endcomponent

        @if (is_edit())
            @include('admin.shared.form.template.timestamp-component',
            [
                'updatedAt' => $package->getUpdatedAt(),
                'createdAt' => $package->getCreatedAt(),
            ])
        @endif

        @include('admin.shared.form.template.save-after-action-component', ['noCreate' => true])

        @include('admin.shared.form.form-submit-button')
    </form>
@endsection
