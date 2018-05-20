@extends('member.layouts.app-form')

@section('heading')
    {!! $title !!}
@endsection

@section('form')

    @component('member.shared.form.form-header-component', ['module' => \App\Menu::class])
        @slot('addNewUrl') {{ route('member.menu.create') }}  @endslot
    @endcomponent

    @php /* @var \App\FriendlyUrl $friendlyUrl */ @endphp
    @php /* @var \App\Menu $menu */ @endphp
    @php /* @var \App\MenuTranslation $menuTranslation */ @endphp
    <form class="form-horizontal form-validation" action="{{ is_create() ? route('member.menu.store') : route('member.menu.update', $menu->id) }}" method="post" enctype="multipart/form-data">
        @if (is_edit())
            {{ method_field('PATCH') }}
        @endif

        {{ csrf_field() }}

        @component('member.shared.form.form-group')
            @slot('label') {{ __('menu.name') }} @endslot
            @slot('input')
                @component('member.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') name @endslot
                    @slot('value') {{ old('name', (is_edit() ? $menuTranslation->getName() : '')) }} @endslot
                    @slot('required') required @endslot
                    @slot('autofocus') autofocus @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('menu.url') }} @endslot
            @slot('input')
                @include('member.shared.form.template.url-component', [
                    'urlId' => (is_edit() ? $menu->getUrlId() : ''),
                    'url' => (is_edit() ? $menu->getUrl() : '')
                ])
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('menu.target') }} @endslot
            @slot('input')
                @component('member.shared.input.select-component')
                    @slot('name') target @endslot
                    @slot('option')
                        @foreach(get_link_target_list() as $linkTarget)
                            <option value="{{ $linkTarget }}" {{ (is_edit() && $menu->getTarget() == $linkTarget ? 'selected' : '') }}>{{ __('common.link_target.' . $linkTarget) }}</option>
                        @endforeach
                    @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('common.status') }} @endslot
            @slot('input')
                @component('member.shared.input.template.status-component', [
                    'value' => old('is_active', (is_edit() ? $menu->isActive() : ''))
                ])
                    @slot('name') is_active @endslot
                @endcomponent
            @endslot
        @endcomponent

        @if (is_edit())
            @include('member.shared.form.template.timestamp-component',
            [
                'updatedAt' => $menu->getUpdatedAt(),
                'createdAt' => $menu->getCreatedAt(),
            ])
        @endif

        @include('member.shared.form.template.save-after-action-component')

        @include('member.shared.form.form-submit-button')
    </form>
@endsection

@section('scripts')
    @include('member.shared.javascript.url-component')
@endsection