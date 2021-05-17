<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 21/4/2018
 * Time: 5:00 PM
 */
?>

@php
    /* @var \Illuminate\Pagination\LengthAwarePaginator|\App\Event[] $eventList */
@endphp

@extends('web.layouts.app', [
    'browserTitle' => 'Events',
    'bodyClass' => 'event-list'
])

@section('content')
    <div class="container">
        <div class="py-5">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="text-theme text-center mb-3">UPCOMING EVENTS & TUTORIALS</h1>
                    @if (count($eventList))
                        <div class="event">
                            @foreach ($eventList as $event)
                                <div class="mb-3 item">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="date text-theme d-inline-block d-sm-block">{{ strtoupper($event->getEventStartAt()->format('d F Y')) }}</div>
                                            <div class="time d-inline-block">{{ $event->getEventStartAt()->format('h:i A') }} - {{ $event->getEventEndAt()->format('h:i A') }}</div>
                                        </div>
                                        <div class="col-sm-4 mb-2">
                                            <div class="name font-weight-bold">{{ $event['event_name'] }}</div>
                                        </div>
                                        <div class="col-sm-4 text-right">
                                            <a href="{{ $event->getRsvpLink() }}" class="btn btn-theme px-5 d-block d-sm-inline-block" target="_blank">RSVP</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{ $eventList->links() }}
                        </div>
                    @else
                        <div>No events updated yet.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
