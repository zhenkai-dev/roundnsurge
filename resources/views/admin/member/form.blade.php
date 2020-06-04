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
            <li class="nav-item">
                <a class="nav-link" id="membership-tab" data-toggle="tab" href="#membership" role="tab" aria-controls="membership" aria-selected="false">{{ trans_choice('entity.membership', 1) }}</a>
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
                            @slot('value') {{ old('name', (is_edit() && $member->getDob() ? carbon_to_calendar($member->getDob()) : '')) }} @endslot
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
        <div class="tab-pane fade" id="membership" role="tabpanel" aria-labelledby="membership-tab">
            <div class="float-right mb-3">
                <a href="javascript:void(0);" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#form-membership"><i class="fa fa-plus"></i> Add new membership</a>
            </div>
            <div class="clearfix"></div>
            <div id="form-membership" class="modal" tabindex="-1" role="dialog">
                <form class="form-horizontal form-validation" action="{{ route('admin.member.membership.store', $member->getId()) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add new membership</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @component('admin.shared.form.form-group')
                                    @slot('label') Select package: @endslot
                                    @slot('input')
                                        @component('admin.shared.input.select-component')
                                            @slot('name') package_id @endslot
                                            @slot('value') {{ old('package_id') }} @endslot
                                            @slot('option')
                                                <option value="" selected>{{ __('common.select_with_hyphen') }}</option>
                                                @foreach(\App\Package::dropdown()->get() as $packageOption)
                                                    @php /* @var \App\Package $packageOption */ @endphp
                                                    <option value="{{ $packageOption->getId() }}">{{ $packageOption->packageTranslation->getName() }}</option>
                                                @endforeach
                                            @endslot
                                            @slot('required') required @endslot
                                        @endcomponent
                                    @endslot
                                @endcomponent
                                
                                @component('admin.shared.form.form-group')
                                    @slot('label') {{ __('membership.validity') }} @endslot
                                    @slot('input')
                                        @component('admin.shared.input.text-component')
                                            @slot('type') text @endslot
                                            @slot('name') expiry_date @endslot
                                            @slot('value') {{ old('expiry_date') }} @endslot
                                            @slot('attributes')
                                                data-name="datepicker"
                                            @endslot
                                        @endcomponent
                                    @endslot
                                @endcomponent
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light border" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ __('common.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if ($member->memberships)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>{{ __('member.membership') }}</th>
                                <th class="text-center">{{ __('membership.validity') }}</th>
                                <th class="text-center">{{ __('common.status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $memberships = $member->memberships->load('package.packageTranslation')->sortByDesc('id');
                            @endphp
                            @foreach ($memberships as $membership)
                                <tr>
                                    <td @if ($member->membership->id == $membership->id)class="font-weight-bold text-success"@endif>
                                        @if ($member->membership->id == $membership->id)
                                            <i class="fa fa-fw fa-star"></i>
                                        @endif
                                        {{ $membership->package->packageTranslation->getName() }}
                                    </td>
                                    <td class="text-center">
                                         @if ($membership->getExpiryDate() === null)
                                            {{ __('membership.lifetime') }}
                                        @else
                                            {{ $membership->getExpiryDate()->toDayDateTimeString() }}
                                        @endif    
                                    </td>
                                    <td class="text-center">
                                        @if ($membership->isExpired())
                                            <span class="text-danger">{{ __('membership.expired') }}</span>
                                        @else
                                            <span class="text-success">{{ __('common.active') }}</span>
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
        </div>
        @endif
    </div>
@endsection

{{-- @section('scripts')
<script>
var expiry_date = $('input[name="expiry_date"]'),
    expiry_start_date = moment(expiry_date.data('start-date'), 'YYYY/MM/DD');
expiry_date.daterangepicker({
    startDate: expiry_start_date,
    singleDatePicker: true,
    autoUpdateInput: false,
    showDropdowns: true
}).on("apply.daterangepicker", function(e, picker) {
    picker.element.val(picker.startDate.format(picker.locale.format));
});
</script>
@endsection --}}