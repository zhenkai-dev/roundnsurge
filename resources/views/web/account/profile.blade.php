@extends('web.layouts.account', [
    'browserTitle' => $title,
    'bodyClass' => 'account-profile'
])

@section('accountContent')
    @php /* @var \App\Member $member */ @endphp
    <form class="form-horizontal form-validation" action="{{ route('web.account.update') }}" method="post" enctype="multipart/form-data">
        {{ method_field('PATCH') }}

        {{ csrf_field() }}

        @component('web.shared.form.form-group')
            @slot('label') {{ __('member.name') }} @endslot
            @slot('input')
                @component('web.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') name @endslot
                    @slot('value') {{ old('name', $member->getName()) }} @endslot
                    @slot('required') required @endslot
                    @slot('autofocus') autofocus @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('web.shared.form.form-group')
            @slot('label') {{ __('member.email') }} @endslot
            @slot('input')
                @component('web.shared.input.text-component')
                    @slot('type') email @endslot
                    @slot('name') email @endslot
                    @slot('value') {{ old('email', $member->getEmail()) }} @endslot
                    @slot('required') required @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('web.shared.form.form-group')
            @slot('label') {{ __('member.dob') }} @endslot
            @slot('input')
                @component('web.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') dob @endslot
                    @slot('value') {{ old('dob', carbon_to_calendar($member->getDob())) }} @endslot
                    @slot('required') required @endslot
                    @slot('attributes')
                        data-name = "datepicker"
                    @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('web.shared.form.form-group')
            @slot('label') {{ __('member.mobile') }} @endslot
            @slot('input')
                @component('web.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') mobile @endslot
                    @slot('value') {{ old('mobile', $member->getMobile()) }} @endslot
                    @slot('required') required @endslot
                @endcomponent
            @endslot
        @endcomponent

        @include('web.shared.form.form-submit-button')
    </form>
@endsection
