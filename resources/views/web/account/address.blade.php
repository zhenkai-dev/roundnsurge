<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 29/4/2018
 * Time: 1:23 AM
 */
?>

@extends('web.layouts.account', [
    'browserTitle' => $title,
    'bodyClass' => 'account-address'
])

@section('accountContent')
    @php /* @var \App\Address $address */ @endphp
    <form class="form-horizontal form-validation" action="{{ route('web.account.address.update') }}" method="post" enctype="multipart/form-data">
        {{ method_field('PATCH') }}

        {{ csrf_field() }}

        @component('web.shared.form.form-group')
            @slot('label') {{ __('address.address1') }} @endslot
            @slot('input')
                @component('web.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') address1 @endslot
                    @slot('value') {{ old('address1', (!is_null($address) ? $address->getAddress1() : '')) }} @endslot
                    @slot('required') required @endslot
                    @slot('autofocus') autofocus @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('web.shared.form.form-group')
            @slot('label') {{ __('address.address2') }} @endslot
            @slot('input')
                @component('web.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') address2 @endslot
                    @slot('value') {{ old('address2', (!is_null($address) ? $address->getAddress2() : '')) }} @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('web.shared.form.form-group')
            @slot('label') {{ __('address.postcode') }} @endslot
            @slot('input')
                @component('web.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') postcode @endslot
                    @slot('value') {{ old('postcode', (!is_null($address) ? $address->getPostcode() : '')) }} @endslot
                    @slot('required') required @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('web.shared.form.form-group')
            @slot('label') {{ __('address.city') }} @endslot
            @slot('input')
                @component('web.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') city @endslot
                    @slot('value') {{ old('city', (!is_null($address) ? $address->getCity() : '')) }} @endslot
                    @slot('required') required @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('web.shared.form.form-group')
            @slot('label') {{ __('address.state') }} @endslot
            @slot('input')
                @component('web.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') state @endslot
                    @slot('value') {{ old('state', (!is_null($address) ? $address->getState() : '')) }} @endslot
                    @slot('required') required @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('web.shared.form.form-group')
            @slot('label') {{ trans_choice('entity.country', 1) }} @endslot
            @slot('input')
                @component('web.shared.input.select-component')
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

        @component('web.shared.form.form-group')
            @slot('label') {{ __('address.phone') }} @endslot
            @slot('input')
                @component('web.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') phone @endslot
                    @slot('value') {{ old('phone', (!is_null($address) ? $address->getPhone() : '')) }} @endslot
                    @slot('required') required @endslot
                @endcomponent
            @endslot
        @endcomponent

        @include('web.shared.form.form-submit-button')
    </form>
@endsection