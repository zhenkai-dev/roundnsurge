@extends('admin.layouts.app-listing')

@section('heading')
    {!! $title !!}
@endsection

@section('listing')
    @php /* @var Illuminate\Pagination\LengthAwarePaginator $events */ @endphp

    @component('admin.shared.listing.listing-header-component', ['module' => \App\Event::class])
        @slot('total') {{ $events->total() }} @endslot
        @slot('addNewUrl') {{ route('admin.event.create') }}  @endslot
    @endcomponent

    @component('admin.shared.listing.filter-form')
        @slot('action') {{ route('admin.event.index') }} @endslot
        @slot('inputs')
            @component('admin.shared.listing.filter-form-group')
                @slot('label') {{ __('event.name') }} @endslot
                @slot('input')
                    @component('admin.shared.input.text-component')
                        @slot('type') text @endslot
                        @slot('name') name @endslot
                        @slot('value') {{ request('name') }} @endslot
                    @endcomponent
                @endslot
            @endcomponent
        @endslot
        @slot('pagination')
            {{ $events->links() }}
        @endslot
    @endcomponent

    @if (count($events))
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="20%">{!! sortable('name', __('event.name')) !!}</th>
                    <th>{{ __('event.rsvp_link') }}</th>
                    <th width="10%" class="text-center">{{ __('common.status') }}</th>
                    <th width="10%"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($events as $event)
                    @php /* @var App\Event $event */ @endphp
                    <tr>
                        <td>
                            <a href="{{ route('admin.event.edit', $event->getId()) }}">{{ $event->eventTranslation->getName() }}</a>
                        </td>
                        <td><a href="{{ $event->getRsvpLink() }}" target="_blank">{{ $event->getRsvpLink() }}</a></td>
                        <td class="text-center">{!! status_icon($event->isActive()) !!}</td>
                        <td class="text-center">
                            @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::UPDATE, $event))
                                {!! edit_icon_muted() !!}
                            @else
                                {!! edit_icon_link(route('admin.event.edit', $event->getId())) !!}
                            @endif

                                @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::DELETE, $event))
                                    {!! delete_icon_muted() !!}
                                @else
                                    {!! delete_icon_link(route('admin.event.destroy', $event->getId())) !!}
                                @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning" role="alert">
            {{ __('message.no_record') }}
        </div>
    @endif

    {{ $events->links() }}
@endsection
