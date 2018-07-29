<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 19/5/2018
 * Time: 9:34 PM
 */
?>

<div class="mb-5">
@php /* @var \App\Page $sidePanel */ @endphp
{!! editor_content($sidePanel->pageTranslation->getDescription()) !!}
</div>

@php /* @var \Illuminate\Database\Eloquent\Collection|\App\Event[] $upcomingEvents */ @endphp
@if (count($upcomingEvents))
    <div class="upcoming-event">
        <h4 class="text-uppercase mb-3">Upcoming Events</h4>

        @foreach ($upcomingEvents as $upcomingEvent)
            <div class="item">
                <a href="{{ $upcomingEvent->getRsvpLink() }}" target="_blank" class="text-theme name">{{ $upcomingEvent->eventTranslation->getName() }}</a>
                <div class="date">{{ $upcomingEvent->getEventStartAt()->format('d F Y') }}</div>
            </div>
        @endforeach

        <a href="{{ route('web.events.index') }}" class="font-weight-bold learn-more">Learn More ></a>
    </div>
@endif
