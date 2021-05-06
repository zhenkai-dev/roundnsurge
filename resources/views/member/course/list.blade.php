@extends('member.layouts.app-listing')

@section('heading')
    {!! $title !!}
@endsection

@section('listing')
    @if (Auth::user()->isActive())
        @php /* @var Illuminate\Pagination\LengthAwarePaginator $courses */ @endphp

        @component('member.shared.listing.listing-header-component', ['module' => \App\Course::class])
            @slot('total') {{ $courses->total() }} @endslot
        @endcomponent

        @component('member.shared.listing.filter-form')
            @slot('action') {{ route('member.course.index') }} @endslot
            @slot('inputs')
                @component('member.shared.listing.filter-form-group')
                    @slot('label') {{ __('course.name') }} @endslot
                    @slot('input')
                        @component('member.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') name @endslot
                            @slot('value') {{ request('name') }} @endslot
                        @endcomponent
                    @endslot
                @endcomponent
            @endslot
            @slot('pagination')
                {{ $courses->links() }}
            @endslot
        @endcomponent

        @if (count($courses))
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{!! sortable('name', __('course.name')) !!}</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($courses as $course)
                        @php /* @var App\Course $course */ @endphp
                        <tr>
                            <td>
                                <a href="{{ route('member.course.show', $course->getId()) }}">{{ $course->courseTranslation->getName() }}</a>
                                <small class="font-italic d-block">{{ str_limit(strip_tags($course->courseTranslation->getDescription())) }}</small>
                            </td>
                            <td class="text-center">
                                @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::VIEW, $course))
                                    {!! view_icon_muted() !!}
                                @else
                                    {!! view_icon_link(route('member.course.show', $course->getId())) !!}
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

        {{ $courses->links() }}
    @else
        Hi, {{Auth::user()->getName()}}. Please register a Mplus account using this <a href="{{ route('web.register.referral') }}" target="_blank">link</a>, 
        our team will verify your account in 3 working days. You can view our course once your account is activated.
    @endif
@endsection
