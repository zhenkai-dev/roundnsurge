@extends('member.layouts.app-listing')

@section('heading')
    {!! $title !!}
@endsection

@section('listing')
    @php /* @var \Illuminate\Database\Eloquent\Collection $menus */ @endphp

    @component('member.shared.listing.listing-header-component', ['module' => \App\Menu::class])
        @slot('total') {{ count($menus) }} @endslot
        @slot('addNewUrl') {{ route('member.menu.create') }}  @endslot
    @endcomponent

    @if (count($menus))
        <div class="dd" id="nestable">
            @include('member.menu.list.item', ['allMenu' => $menus, 'menus' => $menus[0]])
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
                    type: 'PUT', url: '{{ route('member.menu.sortable') }}', dataType: 'json', data: param,
                    success: function (data) {
                        //
                    }
                });
                console.log(list.nestable('serialize'));
            };

            $('#nestable').nestable({
                group: 1
            }).on('change', updateOutput);

        });
    </script>
@endsection
