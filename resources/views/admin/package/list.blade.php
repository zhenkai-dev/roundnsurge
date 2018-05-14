@extends('admin.layouts.app-listing')

@section('heading')
    {!! $title !!}
@endsection

@section('listing')
    @php /* @var Illuminate\Pagination\LengthAwarePaginator $packages */ @endphp

    @component('admin.shared.listing.listing-header-component', ['module' => \App\Package::class])
        @slot('total') {{ $packages->total() }} @endslot
    @endcomponent

    @component('admin.shared.listing.filter-form')
        @slot('action') {{ route('admin.package.index') }} @endslot
        @slot('inputs')
            @component('admin.shared.listing.filter-form-group')
                @slot('label') {{ __('package.name') }} @endslot
                @slot('input')
                    @component('admin.shared.input.text-component')
                        @slot('type') text @endslot
                        @slot('name') name @endslot
                        @slot('value') {{ request('name') }} @endslot
                    @endcomponent
                @endslot
            @endcomponent
        @endslot
        @slot('pagination')
            {{ $packages->links() }}
        @endslot
    @endcomponent

    @if (count($packages))
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{!! sortable('name', __('package.name')) !!}</th>
                        <th>{{ __('package.package_type') }}</th>
                        <th>{{ __('package.price') }}</th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($packages as $package)
                        @php /* @var App\Package $package */ @endphp
                        <tr>
                            <td>
                                <a href="{{ route('admin.package.edit', $package->getId()) }}">{{ $package->packageTranslation->getName() }}</a>
                                <small class="font-italic d-block">{{ str_limit(strip_tags($package->packageTranslation->getDescription())) }}</small>
                            </td>
                            <td>{{ $package->getPackageType() }}</td>
                            <td>{{ currency($package->getPrice()) }}</td>
                            <td class="text-center">
                                @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::UPDATE, $package))
                                    {!! edit_icon_muted() !!}
                                @else
                                    {!! edit_icon_link(route('admin.package.edit', $package->getId())) !!}
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

    {{ $packages->links() }}
@endsection
