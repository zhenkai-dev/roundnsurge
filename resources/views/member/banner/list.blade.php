@extends('member.layouts.app-listing')

@section('heading')
    {!! $title !!}
@endsection

@section('listing')
    @php /* @var \Illuminate\Database\Eloquent\Collection $banners */ @endphp

    @component('member.shared.listing.listing-header-component', ['module' => \App\Banner::class])
        @slot('total') {{ count($banners) }} @endslot
        @slot('addNewUrl') {{ route('member.banner.create') }}  @endslot
    @endcomponent

    @if (count($banners))
        <div class="dd" id="nestable">
            <ol class="dd-list">
                @foreach ($banners as $banner)
                    @php /* @var App\Banner $banner */ @endphp
                    <li class="dd-item" data-id="{{ $banner->getId() }}">
                        <div class="dd-handle clearfix">
                            <div class="pull-left">
                                <img class="mr-2" width="35" src="{{ $banner->getPhotoThumbnailFullUrl() }}">
                                {{ ($banner->bannerTranslation->getName() ? $banner->bannerTranslation->getName() : $banner->getPhoto()) }}
                            </div>
                            <div class="pull-right dd-nodrag">
                                @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::UPDATE, $banner))
                                    {!! edit_icon_muted() !!}
                                @else
                                    {!! edit_icon_link(route('member.banner.edit', $banner->getId())) !!}
                                @endif

                                @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::DELETE, $banner))
                                    {!! delete_icon_muted() !!}
                                @else
                                    {!! delete_icon_link(route('member.banner.destroy', $banner->getId())) !!}
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    @else
        <div class="alert alert-warning" role="alert">
            {{ __('message.no_record') }}
        </div>
    @endif
@endsection

@section('scripts')
    <script src="{{ asset('member/js/jquery.nestable.js') }}"></script>
    <script>
        $(document).ready(function() {
            var updateOutput = function (e) {
                var list = e.length ? e : $(e.target);
                var param = {};
                param['ordering'] = list.nestable('serialize');

                $.ajax({
                    type: 'PUT', url: '{{ route('member.banner.sortable') }}', dataType: 'json', data: param,
                    success: function (data) {
                        //
                    }
                });
            };

            $('#nestable').nestable({
                group: 1,
                maxDepth: 1
            }).on('change', updateOutput);

        });
    </script>
@endsection