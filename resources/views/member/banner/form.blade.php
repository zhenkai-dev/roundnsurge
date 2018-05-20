@extends('member.layouts.app-form')

@section('heading')
    {!! $title !!}
@endsection

@section('form')

    @component('member.shared.form.form-header-component', ['module' => \App\Banner::class])
        @slot('addNewUrl') {{ route('member.banner.create') }}  @endslot
    @endcomponent

    @php /* @var \App\Banner $banner */ @endphp
    @php /* @var \App\BannerTranslation $bannerTranslation */ @endphp
    <form class="form-horizontal form-validation" action="{{ is_create() ? route('member.banner.store') : route('member.banner.update', $banner->id) }}" method="post" enctype="multipart/form-data">
        @if (is_edit())
            {{ method_field('PATCH') }}
        @endif

        {{ csrf_field() }}

        @component('member.shared.form.form-group')
            @slot('label') {{ __('banner.name') }} @endslot
            @slot('input')
                @component('member.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') name @endslot
                    @slot('value') {{ old('name', (is_edit() ? $bannerTranslation->getName() : '')) }} @endslot
                    @slot('autofocus') autofocus @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('banner.photo') }} @endslot
            @slot('input')
                @component('member.shared.input.file-component')
                    @slot('id') photo @endslot
                    @slot('name') photo @endslot
                    @if (!is_edit())
                        @slot('required') required @endslot
                    @endif
                @endcomponent
            @endslot
            @slot('more')
                @if ($banner->getPhoto())
                    <div class="mt-1">
                        <div class="border d-inline-block p-1">
                            <img class="img-fluid" src="{{ $banner->getPhotoFullUrl() }}">
                        </div>
                    </div>

                    <div class="mt-1">
                        <div class="border d-inline-block p-1">
                            <img class="img-fluid" src="{{ $banner->getPhotoThumbnailFullUrl() }}">
                        </div>
                    </div>
                @endif
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('banner.description') }} @endslot
            @slot('input')
                @component('member.shared.input.textarea-component')
                    @slot('id') description @endslot
                    @slot('name') description @endslot
                    @slot('class') autosize @endslot
                    @slot('value') {{ old('description', (is_edit() ? $bannerTranslation->getDescription() : '')) }} @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('menu.url') }} @endslot
            @slot('input')
                @include('member.shared.form.template.url-component', [
                    'urlId' => (is_edit() ? $banner->getUrlId() : ''),
                    'url' => (is_edit() ? $banner->getUrl() : '')
                ])
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('banner.target') }} @endslot
            @slot('input')
                @component('member.shared.input.select-component')
                    @slot('name') target @endslot
                    @slot('option')
                        @foreach(get_link_target_list() as $linkTarget)
                            <option value="{{ $linkTarget }}" {{ (is_edit() && $banner->getTarget() == $linkTarget ? 'selected' : '') }}>{{ __('common.link_target.' . $linkTarget) }}</option>
                        @endforeach
                    @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('common.status') }} @endslot
            @slot('input')
                @component('member.shared.input.template.status-component', [
                    'value' => old('is_active', (is_edit() ? $banner->isActive() : ''))
                ])
                    @slot('name') is_active @endslot
                @endcomponent
            @endslot
        @endcomponent

        @if (is_edit())
            @include('member.shared.form.template.timestamp-component',
            [
                'updatedAt' => $banner->getUpdatedAt(),
                'createdAt' => $banner->getCreatedAt(),
            ])
        @endif

        @include('member.shared.form.template.save-after-action-component')

        @include('member.shared.form.form-submit-button')
    </form>
@endsection

@section('scripts')
    @include('member.shared.javascript.url-component')
@endsection