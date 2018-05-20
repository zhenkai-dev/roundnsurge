@extends('member.layouts.app-listing')

@section('heading')
    {!! $title !!}
@endsection

@section('listing')
    @php /* @var Illuminate\Pagination\LengthAwarePaginator $users */ @endphp

    @component('member.shared.listing.listing-header-component', ['module' => \App\User::class])
        @slot('total') {{ $users->total() }} @endslot
        @slot('addNewUrl') {{ route('member.user.create') }}  @endslot
    @endcomponent

    @component('member.shared.listing.filter-form')
        @slot('action') {{ route('member.user.index') }} @endslot
        @slot('inputs')
            @component('member.shared.listing.filter-form-group')
                @slot('label') {{ __('user.name') }} @endslot
                @slot('input')
                    @component('member.shared.input.text-component')
                        @slot('type') text @endslot
                        @slot('name') name @endslot
                        @slot('value') {{ request('name') }} @endslot
                    @endcomponent
                @endslot
            @endcomponent

            @component('member.shared.listing.filter-form-group')
                @slot('label') {{ __('user.username') }} @endslot
                @slot('input')
                    @component('member.shared.input.text-component')
                        @slot('type') text @endslot
                        @slot('name') username @endslot
                        @slot('value') {{ request('username') }} @endslot
                    @endcomponent
                @endslot
            @endcomponent

            @component('member.shared.listing.filter-form-group')
                @slot('label') {{ __('user.email') }} @endslot
                @slot('input')
                    @component('member.shared.input.text-component')
                        @slot('type') text @endslot
                        @slot('name') email @endslot
                        @slot('value') {{ request('email') }} @endslot
                    @endcomponent
                @endslot
            @endcomponent
        @endslot
        @slot('pagination')
            {{ $users->links() }}
        @endslot
    @endcomponent

    @if (count($users))
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{!! sortable('name', __('user.name')) !!}</th>
                        <th>{!! sortable('username', __('user.username')) !!}</th>
                        <th>{!! sortable('email', __('user.email')) !!}</th>
                        <th class="text-center">{{ __('common.status') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @php /* @var App\User $user */ @endphp
                        <tr>
                            <td><a href="{{ route('member.user.edit', $user->getId()) }}">{{ $user->getName() }}</a></td>
                            <td>{{ $user->getUsername() }}
                            </td>
                            <td>{{ $user->getEmail() }}</td>
                            <td class="text-center">{!! status_icon($user->isActive()) !!}</td>
                            <td class="text-center">
                                @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::UPDATE, $user))
                                    {!! edit_icon_muted() !!}
                                @else
                                    {!! edit_icon_link(route('member.user.edit', $user->getId())) !!}
                                @endif

                                @if ($user->isPersist() || !Auth::user()->can(\App\Enumeration\PolicyActionEnum::DELETE, $user))
                                    {!! delete_icon_muted() !!}
                                @else
                                    {!! delete_icon_link(route('member.user.destroy', $user->getId())) !!}
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

    {{ $users->links() }}
@endsection
