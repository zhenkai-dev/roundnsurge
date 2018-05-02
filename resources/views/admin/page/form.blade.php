@extends('admin.layouts.app-form')

@section('heading')
    {!! $title !!}
@endsection

@section('form')

    @component('admin.shared.form.form-header-component', ['module' => \App\Page::class])
        @slot('addNewUrl') {{ route('admin.page.create') }}  @endslot
    @endcomponent

    @php /* @var \App\FriendlyUrl $friendlyUrl */ @endphp
    @php /* @var \App\Page $page */ @endphp
    @php /* @var \App\PageTranslation $pageTranslation */ @endphp
    <form class="form-horizontal form-validation" action="{{ is_create() ? route('admin.page.store') : route('admin.page.update', $page->id) }}" method="post" enctype="multipart/form-data">
        @if (is_edit())
            {{ method_field('PATCH') }}
        @endif

        {{ csrf_field() }}

        @if (is_edit() && !$page->isModule() && $page->getId() > 1)
            @component('admin.shared.form.form-group')
                @slot('label') {{ __('common.url') }} @endslot
                @slot('input')
                    @component('admin.shared.input.template.friendly-url-component')
                        @slot('urlPath') {{ url('pages') }}/ @endslot
                        @slot('type') text @endslot
                        @slot('value') {{ old('url_name', $friendlyUrl->getName()) }} @endslot
                        @slot('previewUrl') {{ route('web.pages.show', ['slug' => $friendlyUrl->getName()]) }} @endslot
                    @endcomponent
                @endslot
            @endcomponent
        @endif

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('page.name') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') name @endslot
                    @slot('value') {{ old('name', (is_edit() ? $pageTranslation->getName() : '')) }} @endslot
                    @slot('required') required @endslot
                    @slot('autofocus') autofocus @endslot
                @endcomponent
            @endslot
        @endcomponent

        @if(!is_edit() || (is_edit() && !$page->isModule()))
            @component('admin.shared.form.form-group')
                @slot('label') {{ __('page.photo') }} @endslot
                @slot('input')
                    @component('admin.shared.input.file-component')
                        @slot('id') photo @endslot
                        @slot('name') photo @endslot
                    @endcomponent
                @endslot
                @slot('more')
                    @if ($page->getPhoto())
                        <div class="form-check mt-2">
                            <label>
                                <input class="form-check-input" type="checkbox" name="photo_remove" value="1" data-name="disableTarget" data-target="#photo"> Remove photo
                            </label>
                        </div>

                        <div class="mt-1">
                            <div class="border d-inline-block p-1">
                                <img class="img-fluid" src="{{ $page->getPhotoFullUrl() }}">
                            </div>
                        </div>
                    @endif
                @endslot
            @endcomponent
        @endif

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('page.description') }} @endslot
            @slot('input')
                @component('admin.shared.input.textarea-component')
                    @slot('id') description @endslot
                    @slot('name') description @endslot
                    @slot('value') {{ old('description', (is_edit() ? $pageTranslation->getDescription() : '')) }} @endslot
                @endcomponent
            @endslot
        @endcomponent

        @if(!is_edit() || (is_edit() && !$page->isModule()))
            @component('admin.shared.form.form-group')
                @slot('label') {{ __('common.meta_title') }} @endslot
                @slot('input')
                    @component('admin.shared.input.text-component')
                        @slot('type') text @endslot
                        @slot('name') meta_title @endslot
                        @slot('value') {{ old('meta_title', (is_edit() ? $pageTranslation->getMetaTitle() : '')) }} @endslot
                    @endcomponent
                @endslot
            @endcomponent

            @component('admin.shared.form.form-group')
                @slot('label') {{ __('common.meta_keywords') }} @endslot
                @slot('input')
                    @component('admin.shared.input.textarea-component')
                        @slot('name') meta_keywords @endslot
                        @slot('value') {{ old('meta_keywords', (is_edit() ? $pageTranslation->getMetaKeywords() : '')) }} @endslot
                    @endcomponent
                @endslot
                @slot('more')
                    @component('admin.shared.form.help-text-component')
                        {{ __('common.meta_keywords_note') }}
                    @endcomponent
                @endslot
            @endcomponent

            @component('admin.shared.form.form-group')
                @slot('label') {{ __('common.meta_description') }} @endslot
                @slot('input')
                    @component('admin.shared.input.textarea-component')
                        @slot('name') meta_description @endslot
                        @slot('value') {{ old('meta_description', (is_edit() ? $pageTranslation->getMetaDescription() : '')) }} @endslot
                    @endcomponent
                @endslot
                @slot('more')
                    @component('admin.shared.form.help-text-component')
                        {{ __('common.meta_description_note') }}
                    @endcomponent
                @endslot
            @endcomponent
        @endif

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('common.status') }} @endslot
            @slot('input')
                @component('admin.shared.input.template.status-component', [
                    'value' => old('is_active', (is_edit() ? $page->isActive() : ''))
                ])
                    @slot('name') is_active @endslot
                @endcomponent
            @endslot
        @endcomponent

        @if (is_edit())
            @include('admin.shared.form.template.timestamp-component',
            [
                'updatedAt' => $page->getUpdatedAt(),
                'createdAt' => $page->getCreatedAt(),
            ])
        @endif

        @include('admin.shared.form.template.save-after-action-component')

        @include('admin.shared.form.form-submit-button')
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('admin/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'description' );
    </script>
@endsection