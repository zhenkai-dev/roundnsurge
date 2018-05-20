@extends('admin.layouts.app-listing')

@section('heading')
    {!! $title !!}
@endsection

@section('listing')
    @php /* @var Illuminate\Pagination\LengthAwarePaginator $courses */ @endphp

    @component('admin.shared.listing.listing-header-component', ['module' => \App\Course::class])
        @slot('total') {{ $courses->total() }} @endslot
        @slot('addNewUrl') {{ route('admin.course.create') }}  @endslot
    @endcomponent

    @component('admin.shared.listing.filter-form')
        @slot('action') {{ route('admin.course.index') }} @endslot
        @slot('inputs')
            @component('admin.shared.listing.filter-form-group')
                @slot('label') {{ __('course.name') }} @endslot
                @slot('input')
                    @component('admin.shared.input.text-component')
                        @slot('type') text @endslot
                        @slot('name') name @endslot
                        @slot('value') {{ request('name') }} @endslot
                    @endcomponent
                @endslot
            @endcomponent

            @component('admin.shared.listing.filter-form-group')
                @slot('label') {{ trans_choice('entity.package', 2) }} @endslot
                @slot('input')
                    <div>
                        @component('admin.shared.input.bootstrap.radio-component',
                        ['inline' => true, 'checked' => true])
                            @slot('name') package_join @endslot
                            @slot('label') have any @endslot
                            @slot('value') or @endslot
                        @endcomponent

                        @component('admin.shared.input.bootstrap.radio-component',
                        ['inline' => true, 'checked' => (request('package_join') === 'and' ? true : false)])
                            @slot('name') package_join @endslot
                            @slot('label') have only @endslot
                            @slot('value') and @endslot
                        @endcomponent
                    </div>
                    <div>
                        @foreach(\App\Package::getMultipleChoice() as $package)
                            @component('admin.shared.input.bootstrap.checkbox-component',
                            [
                                'inline' => true,
                                'checked' => (!empty(request('packages')) && is_array(request('packages')) && in_array($package->getId(), request('packages')) ? true : (empty(request('packages')) ? true : false))
                            ])
                                @slot('name') packages[] @endslot
                                @slot('label') {{ $package->packageTranslation->getName() }} @endslot
                                @slot('value') {{ $package->getId() }} @endslot
                            @endcomponent
                        @endforeach
                    </div>
                @endslot
            @endcomponent
        @endslot
        @slot('pagination')
            {{ $courses->links() }}
        @endslot
    @endcomponent

    @if (count($courses))
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>{!! sortable('name', __('course.name')) !!}</th>
                    <th width="20%">{{ trans_choice('entity.package', 2) }}</th>
                    <th width="10%" class="text-center">{{ __('common.status') }}</th>
                    <th width="10%"></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($courses as $course)
                    @php /* @var App\Course $course */ @endphp
                    <tr>
                        <td>
                            <a href="{{ route('admin.course.edit', $course->getId()) }}">{{ $course->courseTranslation->getName() }}</a>
                            <small class="font-italic d-block">{{ str_limit(strip_tags($course->courseTranslation->getDescription())) }}</small>
                        </td>
                        <td>
                            @foreach ($course->packages()->get() as $package)
                                <span class="badge badge-success">{{ $package->packageTranslation->getName() }}</span>
                            @endforeach
                        </td>
                        <td class="text-center">{!! status_icon($course->isActive()) !!}</td>
                        <td class="text-center">
                            @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::UPDATE, $course))
                                {!! edit_icon_muted() !!}
                            @else
                                {!! edit_icon_link(route('admin.course.edit', $course->getId())) !!}
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

    {{ $courses->links() }}
@endsection
