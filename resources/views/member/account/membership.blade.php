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
        Validity: Lifetime
    </div>

    <div class="mb-2">
        {{ __('common.status') }}: <span class="text-success">{{ __('common.active') }}</span>
    </div>

    <a class="btn btn-primary" href="{{ route('member.membershipFee') }}">Upgrade package</a>

@endsection
