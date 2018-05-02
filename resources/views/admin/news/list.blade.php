@extends('admin.layouts.app-listing')

@section('heading')
    {!! $title !!}
@endsection

@section('listing')
    @php /* @var Illuminate\Pagination\LengthAwarePaginator $newsList */ @endphp

    @component('admin.shared.listing.listing-header-component', ['module' => \App\News::class])
        @slot('total') {{ $newsList->total() }} @endslot
        @slot('addNewUrl') {{ route('admin.news.create') }}  @endslot
    @endcomponent

    @component('admin.shared.listing.filter-form')
        @slot('action') {{ route('admin.news.index') }} @endslot
        @slot('inputs')
            @component('admin.shared.listing.filter-form-group')
                @slot('label') {{ __('news.name') }} @endslot
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
            {{ $newsList->links() }}
        @endslot
    @endcomponent

    @if (count($newsList))
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{!! sortable('name', __('news.name')) !!}</th>
                        <th width="10%" class="text-center">{{ __('common.status') }}</th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($newsList as $news)
                        @php /* @var App\News $news */ @endphp
                        <tr>
                            <td>
                                <a href="{{ route('admin.news.edit', $news->getId()) }}">{{ $news->newsTranslation->getName() }}</a>
                                <small class="font-italic d-block">{{ str_limit(strip_tags($news->newsTranslation->getDescription())) }}</small>
                            </td>
                            </td>
                            <td class="text-center">{!! status_icon($news->isActive()) !!}</td>
                            <td class="text-center">
                                @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::UPDATE, $news))
                                    {!! edit_icon_muted() !!}
                                @else
                                    {!! edit_icon_link(route('admin.news.edit', $news->getId())) !!}
                                @endif

                                @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::DELETE, $news))
                                    {!! delete_icon_muted() !!}
                                @else
                                    {!! delete_icon_link(route('admin.news.destroy', $news->getId())) !!}
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

    {{ $newsList->links() }}
@endsection
