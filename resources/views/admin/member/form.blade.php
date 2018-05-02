@extends('admin.layouts.app-form')

@section('heading')
    {!! $title !!}
@endsection

@section('form')

    @component('admin.shared.form.form-header-component', ['module' => \App\Member::class])
        @slot('addNewUrl') {{ route('admin.member.create') }}  @endslot
    @endcomponent

    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="detail-tab" data-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="true">Detail</a>
        </li>
        @if (is_edit())
            <li class="nav-item">
                <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab" aria-controls="address" aria-selected="false">{{ trans_choice('entity.address', 1) }}</a>
            </li>
        @endif
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="detail-tab">
            @php /* @var \App\Member $member */ @endphp
            <form class="form-horizontal form-validation" action="{{ is_create() ? route('admin.member.store') : route('admin.member.update', $member->getId()) }}" method="post" enctype="multipart/form-data">
                @if (is_edit())
                    {{ method_field('PATCH') }}
                @endif

                {{ csrf_field() }}

                @component('admin.shared.form.form-group')
                    @slot('label') {{ __('member.name') }} @endslot
                    @slot('input')
                        @component('admin.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') name @endslot
                            @slot('value') {{ old('name', (is_edit() ? $member->getName() : '')) }} @endslot
                            @slot('required') required @endslot
                            @slot('autofocus') autofocus @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('admin.shared.form.form-group')
                    @slot('label') {{ __('member.mobile') }} @endslot
                    @slot('input')
                        @component('admin.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') mobile @endslot
                            @slot('value') {{ old('name', (is_edit() ? $member->getMobile() : '')) }} @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('admin.shared.form.form-group')
                    @slot('label') {{ __('member.dob') }} @endslot
                    @slot('input')
                        @component('admin.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') dob @endslot
                            @slot('value') {{ old('name', (is_edit() ? carbon_to_calendar($member->getDob()) : '')) }} @endslot
                            @slot('attributes')
                                data-name = "datepicker"
                            @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('admin.shared.form.form-group')
                    @slot('label') {{ __('member.email') }} @endslot
                    @slot('input')
                        @component('admin.shared.input.text-component')
                            @slot('type') email @endslot
                            @slot('name') email @endslot
                            @slot('value') {{ old('email', (is_edit() ? $member->getEmail() : '')) }} @endslot
                            @slot('required') required @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('admin.shared.form.form-group')
                    @slot('label') {{ __('member.password') }} @endslot
                    @slot('input')
                        @component('admin.shared.input.text-component')
                            @slot('type') password @endslot
                            @slot('name') password @endslot
                            @slot('id') password @endslot
                            @if (is_create())
                                @slot('required') required @endslot
                            @endif
                        @endcomponent
                    @endslot
                @endcomponent

                @component('admin.shared.form.form-group')
                    @slot('label') {{ __('member.password_confirm') }} @endslot
                    @slot('input')
                        @component('admin.shared.input.text-component')
                            @slot('type') password @endslot
                            @slot('name') password_confirm @endslot
                            @slot('id') password_confirm @endslot
                            @slot('attributes')
                                minlength = "8"
                                maxlength = "20"
                                equalTo = "#password"
                                data-val-equalto = "{{ ucfirst(__('validation.same', ['attribute' => 'Confirm password', 'other' => 'Password'])) }}"
                            @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('admin.shared.form.form-group')
                    @slot('label') {{ __('common.status') }} @endslot
                    @slot('input')
                        @component('admin.shared.input.template.status-component', [
                            'value' => old('is_active', (is_edit() ? $member->isActive() : ''))
                        ])
                            @slot('name') is_active @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @if (is_edit())
                    @if ($member->getAddedBy())
                        @component('admin.shared.form.form-group-text')
                            @slot('label') {{ __('common.created_by') }} @endslot
                            @slot('text') {{ $member->addedBy()->first()->getName() }} @endslot
                        @endcomponent
                    @endif

                    @include('admin.shared.form.template.timestamp-component',
                    [
                        'updatedAt' => $member->getUpdatedAt(),
                        'createdAt' => $member->getCreatedAt(),
                    ])
                @endif

                @include('admin.shared.form.template.save-after-action-component')

                @include('admin.shared.form.form-submit-button')
            </form>
        </div>

        @if (is_edit())
            <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
            @php /* @var \App\Address $address */ @endphp
            <form class="form-horizontal form-validation" action="{{ route('admin.member.address.update', $member->getId()) }}" method="post" enctype="multipart/form-data">
                @if (is_edit())
                    {{ method_field('PATCH') }}
                @endif

                {{ csrf_field() }}

                @component('admin.shared.form.form-group')
                    @slot('label') {{ __('address.address1') }} @endslot
                    @slot('input')
                        @component('admin.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') address1 @endslot
                            @slot('value') {{ old('address1', (!is_null($address) ? $address->getAddress1() : '')) }} @endslot
                            @slot('required') required @endslot
                            @slot('autofocus') autofocus @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('admin.shared.form.form-group')
                    @slot('label') {{ __('address.address2') }} @endslot
                    @slot('input')
                        @component('admin.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') address2 @endslot
                            @slot('value') {{ old('address2', (!is_null($address) ? $address->getAddress2() : '')) }} @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('admin.shared.form.form-group')
                    @slot('label') {{ __('address.postcode') }} @endslot
                    @slot('input')
                        @component('admin.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') postcode @endslot
                            @slot('value') {{ old('postcode', (!is_null($address) ? $address->getPostcode() : '')) }} @endslot
                            @slot('required') required @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('admin.shared.form.form-group')
                    @slot('label') {{ __('address.city') }} @endslot
                    @slot('input')
                        @component('admin.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') city @endslot
                            @slot('value') {{ old('city', (!is_null($address) ? $address->getCity() : '')) }} @endslot
                            @slot('required') required @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('admin.shared.form.form-group')
                    @slot('label') {{ __('address.state') }} @endslot
                    @slot('input')
                        @component('admin.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') state @endslot
                            @slot('value') {{ old('state', (!is_null($address) ? $address->getState() : '')) }} @endslot
                            @slot('required') required @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @component('admin.shared.form.form-group')
                    @slot('label') {{ trans_choice('entity.country', 1) }} @endslot
                    @slot('input')
                        @component('admin.shared.input.select-component')
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

                @component('admin.shared.form.form-group')
                    @slot('label') {{ __('address.phone') }} @endslot
                    @slot('input')
                        @component('admin.shared.input.text-component')
                            @slot('type') text @endslot
                            @slot('name') phone @endslot
                            @slot('value') {{ old('phone', (!is_null($address) ? $address->getPhone() : '')) }} @endslot
                            @slot('required') required @endslot
                        @endcomponent
                    @endslot
                @endcomponent

                @include('admin.shared.form.template.save-after-action-component')

                @include('admin.shared.form.form-submit-button')
            </form>
        </div>
        @endif
    </div>
@endsection
