@extends('member.layouts.app-form')

@section('heading')
    {!! $title !!}
@endsection

@section('form')

    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="true">Detail</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false">{{ trans_choice('entity.address', 1) }}</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="detail-tab">
            @php /* @var \App\Member $member */ @endphp
            <form class="form-horizontal form-validation" action="{{ route('member.account.update') }}" method="post" enctype="multipart/form-data">
                {{ method_field('PATCH') }}

                {{ csrf_field() }}

                @component('member.shared.form.form-group')
                    @slot('label') {{ __('member.name') }} @endslot
                    @slot('input')
                        @component('member.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') name @endslot
                            @slot('value') {{ old('name', $member->getName()) }} @endslot
                            @slot('required') required @endslot
                            @slot('autofocus') autofocus @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('member.shared.form.form-group')
                    @slot('label') {{ __('member.email') }} @endslot
                    @slot('input')
                        @component('member.shared.input.text-component')
                            @slot('type') email @endslot
                            @slot('name') email @endslot
                            @slot('value') {{ old('email', $member->getEmail()) }} @endslot
                            @slot('required') required @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('member.shared.form.form-group')
                    @slot('label') {{ __('member.mobile') }} @endslot
                    @slot('input')
                        @component('member.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') mobile @endslot
                            @slot('value') {{ old('name', $member->getMobile()) }} @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('member.shared.form.form-group')
                    @slot('label') {{ __('member.dob') }} @endslot
                    @slot('input')
                        @component('member.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') dob @endslot
                            @slot('value') {{ old('name', ($member->getDob() ? carbon_to_calendar($member->getDob()) : '')) }} @endslot
                            @slot('attributes')
                                data-name = "datepicker"
                            @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @include('member.shared.form.template.timestamp-component',
                [
                    'updatedAt' => $member->getUpdatedAt(),
                    'createdAt' => $member->getCreatedAt(),
                ])

                @include('member.shared.form.form-submit-button')
            </form>
        </div>
        <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
            @php /* @var \App\Address $address */ @endphp
            <form class="form-horizontal form-validation" action="{{ route('member.account.address.update') }}" method="post" enctype="multipart/form-data">
                {{ method_field('PATCH') }}

                {{ csrf_field() }}

                @component('member.shared.form.form-group')
                    @slot('label') {{ __('address.address1') }} @endslot
                    @slot('input')
                        @component('member.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') address1 @endslot
                            @slot('value') {{ old('address1', (!is_null($address) ? $address->getAddress1() : '')) }} @endslot
                            @slot('required') required @endslot
                            @slot('autofocus') autofocus @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('member.shared.form.form-group')
                    @slot('label') {{ __('address.address2') }} @endslot
                    @slot('input')
                        @component('member.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') address2 @endslot
                            @slot('value') {{ old('address2', (!is_null($address) ? $address->getAddress2() : '')) }} @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('member.shared.form.form-group')
                    @slot('label') {{ __('address.postcode') }} @endslot
                    @slot('input')
                        @component('member.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') postcode @endslot
                            @slot('value') {{ old('postcode', (!is_null($address) ? $address->getPostcode() : '')) }} @endslot
                            @slot('required') required @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('member.shared.form.form-group')
                    @slot('label') {{ __('address.city') }} @endslot
                    @slot('input')
                        @component('member.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') city @endslot
                            @slot('value') {{ old('city', (!is_null($address) ? $address->getCity() : '')) }} @endslot
                            @slot('required') required @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('member.shared.form.form-group')
                    @slot('label') {{ __('address.state') }} @endslot
                    @slot('input')
                        @component('member.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') state @endslot
                            @slot('value') {{ old('state', (!is_null($address) ? $address->getState() : '')) }} @endslot
                            @slot('required') required @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('member.shared.form.form-group')
                    @slot('label') {{ trans_choice('entity.country', 1) }} @endslot
                    @slot('input')
                        @component('member.shared.input.select-component')
                            @slot('name') country_id @endslot
                            @slot('value') {{ old('state', (!is_null($address) ? $address->getState() : '')) }} @endslot
                            @slot('option')
                                <option value="" selected>{{ __('common.select_with_hyphen') }}</option>
                                @foreach(\App\Country::dropdown()->get() as $country)
                                    @php /* @var \App\Country $country */ @endphp
                                    <option value="{{ $country->getId() }}"
                                            {{ (!is_null($address) && $address->getCountryId() == $country->getId() ? 'selected' : '') }}
                                    >{{ $country->getName() }}</option>
                                @endforeach
                            @endslot
                            @slot('required') required @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('member.shared.form.form-group')
                    @slot('label') {{ __('address.phone') }} @endslot
                    @slot('input')
                        @component('member.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') phone @endslot
                            @slot('value') {{ old('phone', (!is_null($address) ? $address->getPhone() : '')) }} @endslot
                            @slot('required') required @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @include('member.shared.form.form-submit-button')
            </form>
        </div>
    </div>
@endsection
