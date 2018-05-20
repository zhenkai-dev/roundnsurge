@extends('member.layouts.app-listing')

@section('heading')
    {!! $title !!}
@endsection

@section('listing')
    @php /* @var Illuminate\Pagination\LengthAwarePaginator $pages */ @endphp

    @component('member.shared.listing.listing-header-component', ['module' => \App\Page::class])
        @slot('total') {{ $pages->total() }} @endslot
        @slot('addNewUrl') {{ route('member.page.create') }}  @endslot
    @endcomponent

    @component('member.shared.listing.filter-form')
        @slot('action') {{ route('member.page.index') }} @endslot
        @slot('inputs')
            @component('member.shared.listing.filter-form-group')
                @slot('label') {{ __('page.name') }} @endslot
                @slot('input')
                    @component('member.shared.input.text-component')
                        @slot('type') text @endslot
                        @slot('name') name @endslot
                        @slot('value') {{ request('name') }} @endslot
                    @endcomponent
                @endslot
            @endcomponent
        @endslot
        @slot('pagination')
            {{ $pages->links() }}
        @endslot
    @endcomponent

    @if (count($pages))
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{!! sortable('name', __('page.name')) !!}</th>
                        <th width="10%" class="text-center">{{ __('common.status') }}</th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pages as $page)
                        @php /* @var App\Page $page */ @endphp
                        <tr>
                            <td>
                                <a href="{{ route('member.page.edit', $page->getId()) }}">{{ $page->pageTranslation->getName() }}</a>
                                <small class="font-italic d-block">{{ str_limit(strip_tags($page->pageTranslation->getDescription())) }}</small>
                            </td>
                            </td>
                            <td class="text-center">{!! status_icon($page->isActive()) !!}</td>
                            <td class="text-center">
                                @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::UPDATE, $page))
                                    {!! edit_icon_muted() !!}
                                @else
                                    {!! edit_icon_link(route('member.page.edit', $page->getId())) !!}
                                @endif

                                @if ($page->isPersist() || !Auth::user()->can(\App\Enumeration\PolicyActionEnum::DELETE, $page))
                                    {!! delete_icon_muted() !!}
                                @else
                                    {!! delete_icon_link(route('member.page.destroy', $page->getId())) !!}
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

    {{ $pages->links() }}
@endsection
