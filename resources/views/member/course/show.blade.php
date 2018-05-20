@extends('member.layouts.app-show')

@section('heading')
    {!! $title !!}
@endsection

@section('show')

    @php /* @var \App\Course $course */ @endphp
    @php /* @var \App\CourseTranslation $courseTranslation */ @endphp

    <h1>{{ $title }}</h1>

    <p>{!! nl2br($courseTranslation->getDescription()) !!}</p>

    <div class="embed-responsive embed-responsive-16by9 my-3">
        {!! $course->getEmbedVideo() !!}
    </div>

    <a href="{{ URL::previous() }}" class="btn btn-light border" role="button">{{ __('common.back_to_previous') }}</a>

@endsection
