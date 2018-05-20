@extends('admin.layouts.app-form')

@section('heading')
    {!! $title !!}
@endsection

@section('form')

    @component('admin.shared.form.form-header-component', ['module' => \App\Course::class])
        @slot('addNewUrl') {{ route('admin.course.create') }}  @endslot
    @endcomponent

    @php /* @var \App\Course $course */ @endphp
    @php /* @var \App\CourseTranslation $courseTranslation */ @endphp
    <form class="form-horizontal form-validation" action="{{ is_create() ? route('admin.course.store') : route('admin.course.update', $course->id) }}" method="post" enctype="multipart/form-data">
        @if (is_edit())
            {{ method_field('PATCH') }}
        @endif

        {{ csrf_field() }}

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('course.name') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') name @endslot
                    @slot('value') {{ old('name', (is_edit() ? $courseTranslation->getName() : '')) }} @endslot
                    @slot('required') required @endslot
                    @slot('autofocus') autofocus @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('course.package') }} @endslot
            @slot('input')
                @foreach(\App\Package::getMultipleChoice() as $package)
                    @component('admin.shared.input.bootstrap.checkbox-component',
                    ['checked' => (in_array($package->getId(), $course->packages->pluck('id')->toArray()) ? true : false)])
                        @slot('name') packages[] @endslot
                        @slot('required') required @endslot
                        @slot('label') {{ $package->packageTranslation->getName() }} @endslot
                        @slot('value') {{ $package->getId() }} @endslot
                    @endcomponent
                @endforeach

                <label class="text-danger" for="packages[]" style="display: none"></label>
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('course.embed_video') }} @endslot
            @slot('input')
                @component('admin.shared.input.textarea-component')
                    @slot('class') autosize @endslot
                    @slot('name') embed_video @endslot
                    @slot('required') required @endslot
                    @slot('value') {{ old('embed_video', (is_edit() ? $course->getEmbedVideo() : '')) }} @endslot
                @endcomponent

                @if (is_edit())
                    <div class="embed-responsive embed-responsive-16by9 mt-3">
                        {!! $course->getEmbedVideo() !!}
                    </div>
                @endif
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('course.description') }} @endslot
            @slot('input')
                @component('admin.shared.input.textarea-component')
                    @slot('class') autosize @endslot
                    @slot('name') description @endslot
                    @slot('value') {{ old('description', (is_edit() ? $courseTranslation->getDescription() : '')) }} @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('common.status') }} @endslot
            @slot('input')
                @component('admin.shared.input.template.status-component', [
                    'value' => old('is_active', (is_edit() ? $course->isActive() : ''))
                ])
                    @slot('name') is_active @endslot
                @endcomponent
            @endslot
        @endcomponent

        @if (is_edit())
            @include('admin.shared.form.template.timestamp-component',
            [
                'updatedAt' => $course->getUpdatedAt(),
                'createdAt' => $course->getCreatedAt(),
            ])
        @endif

        @include('admin.shared.form.template.save-after-action-component')

        @include('admin.shared.form.form-submit-button')
    </form>
@endsection
