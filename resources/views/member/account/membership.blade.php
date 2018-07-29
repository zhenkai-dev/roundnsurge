@extends('member.layouts.app-form')

@section('heading')
    {!! $title !!}
@endsection

@section('form')

    @php /* @var \App\Membership $membership */ @endphp
    @php /* @var \App\Package $package */ @endphp

    <div class="mb-2">
        {{ trans_choice('entity.package', 1) }}: {{ $package->packageTranslation->getName() }}
    </div>

    <div class="mb-2">
        @if ($membership->getExpiryDate() === null)
            {{ __('membership.validity') }}: {{ __('membership.lifetime') }}
        @else
            {{ __('membership.validity') }}: {{ $membership->getExpiryDate()->toDayDateTimeString() }}
        @endif
    </div>

    <div class="mb-2">
        {{ __('common.status') }}:

        @if ($membership->isExpired())
            <span class="text-danger">{{ __('membership.expired') }}</span>
        @else
            <span class="text-success">{{ __('common.active') }}</span>
        @endif
    </div>

    <div class="bg-light p-3">
        @if ($package->getPackageType() === \App\Package::BASIC)
            <form action="{{ route('member.account.upgradeMembership') }}" method="post">
                {{ csrf_field() }}

                <div>
                    <div class="form-inline mb-3">
                        <label class="col-form-label mr-3">
                            Select package:
                        </label>
                        @component('member.shared.input.select-component')
                            @slot('name') package_id @endslot
                            @slot('option')
                                <option value="" selected>{{ __('common.select_with_hyphen') }}</option>
                                @foreach(\App\Package::dropdownPaidPackage()->get() as $packageOption)
                                    @php /* @var \App\Package $packageOption */ @endphp
                                    <option value="{{ $packageOption->getId() }}">{{ $packageOption->packageTranslation->getName() }}</option>
                                @endforeach
                            @endslot
                            @slot('required') required @endslot
                        @endcomponent
                    </div>
                </div>

                <input type="hidden" name="type" value="upgrade">
                <button type="submit" class="btn btn-primary">{{ __('membership.upgrade_package') }}</button>
            </form>
        @else
            <form action="{{ route('member.account.upgradeMembership') }}" method="post">
                {{ csrf_field() }}

                <div>
                    <div class="form-inline mb-3">
                        <label class="col-form-label mr-3">
                            Select package:
                        </label>
                        @component('member.shared.input.select-component')
                            @slot('name') package_id @endslot
                            @slot('option')
                                <option value="" selected>{{ __('common.select_with_hyphen') }}</option>
                                @foreach(\App\Package::dropdownPaidPackage()->get() as $packageOption)
                                    @php /* @var \App\Package $packageOption */ @endphp
                                    <option value="{{ $packageOption->getId() }}">{{ $packageOption->packageTranslation->getName() }}</option>
                                @endforeach
                            @endslot
                            @slot('required') required @endslot
                        @endcomponent
                    </div>
                </div>

                <input type="hidden" name="type" value="renew">
                <button type="submit" class="btn btn-primary">{{ __('membership.renew_or_upgrade_package') }}</button>
            </form>
        @endif

    </div>

@endsection
