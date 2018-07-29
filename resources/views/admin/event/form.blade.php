@extends('admin.layouts.app-form')

@section('heading')
    {!! $title !!}
@endsection

@section('form')

    @component('admin.shared.form.form-header-component', ['module' => \App\Event::class])
        @slot('addNewUrl') {{ route('admin.event.create') }}  @endslot
    @endcomponent

    @php /* @var \App\Event $event */ @endphp
    @php /* @var \App\EventTranslation $eventTranslation */ @endphp
    <form class="form-horizontal form-validation" action="{{ is_create() ? route('admin.event.store') : route('admin.event.update', $event->id) }}" method="post" enctype="multipart/form-data">
        @if (is_edit())
            {{ method_field('PATCH') }}
        @endif

        {{ csrf_field() }}

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('event.name') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') name @endslot
                    @slot('value') {{ old('name', (is_edit() ? $eventTranslation->getName() : '')) }} @endslot
                    @slot('required') required @endslot
                    @slot('autofocus') autofocus @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('event.event_start_at') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('attributes') data-name="datetimepicker" @endslot
                    @slot('name') event_start_at @endslot
                    @slot('required') required @endslot
                    @slot('value') {{ old('event_start_at', (is_edit() ? carbon_to_calendar_with_time($event->getEventStartAt()) : carbon_to_calendar_with_time(\Carbon\Carbon::now()))) }} @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('event.event_end_at') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('attributes') data-name="datetimepicker" @endslot
                    @slot('name') event_end_at @endslot
                    @slot('required') required @endslot
                    @slot('value') {{ old('event_end_at', (is_edit() ? carbon_to_calendar_with_time($event->getEventEndAt()) : carbon_to_calendar_with_time(\Carbon\Carbon::now()))) }} @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('event.rsvp_link') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') rsvp_link @endslot
                    @slot('value') {{ old('rsvp_link', (is_edit() ? $event->getRsvpLink() : '')) }} @endslot
                    @slot('required') required @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('common.status') }} @endslot
            @slot('input')
                @component('admin.shared.input.template.status-component', [
                    'value' => old('is_active', (is_edit() ? $event->isActive() : ''))
                ])
                    @slot('name') is_active @endslot
                @endcomponent
            @endslot
        @endcomponent

        @if (is_edit())
            @include('admin.shared.form.template.timestamp-component',
            [
                'updatedAt' => $event->getUpdatedAt(),
                'createdAt' => $event->getCreatedAt(),
            ])
        @endif

        @include('admin.shared.form.template.save-after-action-component')

        @include('admin.shared.form.form-submit-button')
    </form>
@endsection
