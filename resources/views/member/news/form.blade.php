@extends('member.layouts.app-form')

@section('heading')
    {!! $title !!}
@endsection

@section('form')

    @component('member.shared.form.form-header-component', ['module' => \App\News::class])
        @slot('addNewUrl') {{ route('member.news.create') }}  @endslot
    @endcomponent

    @php /* @var \App\FriendlyUrl $friendlyUrl */ @endphp
    @php /* @var \App\News $news */ @endphp
    @php /* @var \App\NewsTranslation $newsTranslation */ @endphp
    <form class="form-horizontal form-validation" action="{{ is_create() ? route('member.news.store') : route('member.news.update', $news->id) }}" method="post" enctype="multipart/form-data">
        @if (is_edit())
            {{ method_field('PATCH') }}
        @endif

        {{ csrf_field() }}

        @if (is_edit())
            @component('member.shared.form.form-group')
                @slot('label') {{ __('common.url') }} @endslot
                @slot('input')
                    @component('member.shared.input.template.friendly-url-component')
                        @slot('urlPath') {{ url('news') }}/ @endslot
                        @slot('type') text @endslot
                        @slot('value') {{ old('url_name', $friendlyUrl->getName()) }} @endslot
                        @slot('previewUrl') {{ route('web.news.show', ['slug' => $friendlyUrl->getName()]) }} @endslot
                    @endcomponent
                @endslot
            @endcomponent
        @endif

        @component('member.shared.form.form-group')
            @slot('label') {{ __('news.name') }} @endslot
            @slot('input')
                @component('member.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') name @endslot
                    @slot('value') {{ old('name', (is_edit() ? $newsTranslation->getName() : '')) }} @endslot
                    @slot('required') required @endslot
                    @slot('autofocus') autofocus @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('news.post_date') }} @endslot
            @slot('input')
                @component('member.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('attributes') data-name="datepicker" @endslot
                    @slot('name') post_date @endslot
                    @slot('required') required @endslot
                    @slot('value') {{ old('post_date', (is_edit() ? carbon_to_calendar($news->getPostDate()) : carbon_to_calendar(\Carbon\Carbon::now()))) }} @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('news.photo') }} @endslot
            @slot('input')
                @component('member.shared.input.file-component')
                    @slot('id') photo @endslot
                    @slot('name') photo @endslot
                @endcomponent
            @endslot
            @slot('more')
                @if ($news->getPhoto())
                    <div class="form-check mt-2">
                        <label>
                            <input class="form-check-input" type="checkbox" name="photo_remove" value="1" data-name="disableTarget" data-target="#photo"> Remove photo
                        </label>
                    </div>

                    <div class="mt-1">
                        <div class="border d-inline-block p-1">
                            <img class="img-fluid" src="{{ $news->getPhotoFullUrl() }}">
                        </div>
                    </div>
                @endif
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('news.description') }} @endslot
            @slot('input')
                @component('member.shared.input.textarea-component')
                    @slot('id') description @endslot
                    @slot('name') description @endslot
                    @slot('value') {{ old('description', (is_edit() ? $newsTranslation->getDescription() : '')) }} @endslot
                    @slot('required') required @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('common.meta_title') }} @endslot
            @slot('input')
                @component('member.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') meta_title @endslot
                    @slot('value') {{ old('meta_title', (is_edit() ? $newsTranslation->getMetaTitle() : '')) }} @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('common.meta_keywords') }} @endslot
            @slot('input')
                @component('member.shared.input.textarea-component')
                    @slot('name') meta_keywords @endslot
                    @slot('value') {{ old('meta_keywords', (is_edit() ? $newsTranslation->getMetaKeywords() : '')) }} @endslot
                @endcomponent
            @endslot
            @slot('more')
                @component('member.shared.form.help-text-component')
                    {{ __('common.meta_keywords_note') }}
                @endcomponent
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('common.meta_description') }} @endslot
            @slot('input')
                @component('member.shared.input.textarea-component')
                    @slot('name') meta_description @endslot
                    @slot('value') {{ old('meta_description', (is_edit() ? $newsTranslation->getMetaDescription() : '')) }} @endslot
                @endcomponent
            @endslot
            @slot('more')
                @component('member.shared.form.help-text-component')
                    {{ __('common.meta_description_note') }}
                @endcomponent
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('common.status') }} @endslot
            @slot('input')
                @component('member.shared.input.template.status-component', [
                    'value' => old('is_active', (is_edit() ? $news->isActive() : ''))
                ])
                    @slot('name') is_active @endslot
                @endcomponent
            @endslot
        @endcomponent

        @if (is_edit())
            @include('member.shared.form.template.timestamp-component',
            [
                'updatedAt' => $news->getUpdatedAt(),
                'createdAt' => $news->getCreatedAt(),
            ])
        @endif

        @include('member.shared.form.template.save-after-action-component')

        @include('member.shared.form.form-submit-button')
    </form>
@endsection

@section('scripts')
    <script src="{{ asset('member/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace( 'description' );
    </script>
@endsection