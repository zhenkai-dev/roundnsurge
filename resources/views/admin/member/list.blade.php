@extends('admin.layouts.app-listing')

@section('heading')
    {!! $title !!}
@endsection

@section('listing')
    @php /* @var Illuminate\Pagination\LengthAwarePaginator $members */ @endphp

    @component('admin.shared.listing.listing-header-component', ['module' => \App\Member::class])
        @slot('total') {{ $members->total() }} @endslot
        @slot('addNewUrl') {{ route('admin.member.create') }}  @endslot
    @endcomponent

    @component('admin.shared.listing.filter-form')
        @slot('action') {{ route('admin.member.index') }} @endslot
        @slot('inputs')
            @component('admin.shared.listing.filter-form-group')
                @slot('label') {{ __('member.name') }} @endslot
                @slot('input')
                    @component('admin.shared.input.text-component')
                        @slot('type') text @endslot
                        @slot('name') name @endslot
                        @slot('value') {{ request('name') }} @endslot
                    @endcomponent
                @endslot
            @endcomponent

            @component('admin.shared.listing.filter-form-group')
                @slot('label') {{ __('member.mobile') }} @endslot
                @slot('input')
                    @component('admin.shared.input.text-component')
                        @slot('type') text @endslot
                        @slot('name') mobile @endslot
                        @slot('value') {{ request('mobile') }} @endslot
                    @endcomponent
                @endslot
            @endcomponent

            @component('admin.shared.listing.filter-form-group')
                @slot('label') {{ __('member.email') }} @endslot
                @slot('input')
                    @component('admin.shared.input.text-component')
                        @slot('type') text @endslot
                        @slot('name') email @endslot
                        @slot('value') {{ request('email') }} @endslot
                    @endcomponent
                @endslot
            @endcomponent
        @endslot
        @slot('pagination')
            {{ $members->links() }}
        @endslot
    @endcomponent

    @if (count($members))
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{!! sortable('name', __('member.name')) !!}</th>
                        <th>{!! sortable('mobile', __('member.mobile')) !!}</th>
                        <th>{!! sortable('email', __('member.email')) !!}</th>
                        <th class="text-center">{{ __('common.status') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $member)
                        @php /* @var App\Member $member */ @endphp
                        <tr>
                            <td><a href="{{ route('admin.member.edit', $member->getId()) }}">{{ $member->getName() }}</a></td>
                            <td>{{ $member->getMobile() }}</td>
                            <td>{{ $member->getEmail() }}</td>
                            <td class="text-center">{!! status_icon($member->isActive()) !!}</td>
                            <td class="text-center">
                                @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::UPDATE, $member))
                                    {!! edit_icon_muted() !!}
                                @else
                                    {!! edit_icon_link(route('admin.member.edit', $member->getId())) !!}
                                @endif

                                @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::DELETE, $member))
                                    {!! delete_icon_muted() !!}
                                @else
                                    {!! delete_icon_link(route('admin.member.destroy', $member->getId())) !!}
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

    {{ $members->links() }}
@endsection
