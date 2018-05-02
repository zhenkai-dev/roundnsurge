<ol class="dd-list">
    @php /* @var \App\Menu[] $menus */ @endphp
    @foreach($menus as $key => $menu)
        <li class="dd-item" data-id="{{ $menu->getId() }}">
            <div class="dd-handle clearfix">
                <div class="pull-left">{{ $menu->menuTranslation->getName() }}</div>
                <div class="pull-right dd-nodrag">
                    @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::UPDATE, $menu))
                        {!! edit_icon_muted() !!}
                    @else
                        {!! edit_icon_link(route('admin.menu.edit', $menu->getId())) !!}
                    @endif

                    @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::DELETE, $menu))
                        {!! delete_icon_muted() !!}
                    @else
                        {!! delete_icon_link(route('admin.menu.destroy', $menu->getId())) !!}
                    @endif
                </div>
            </div>

            @if (!empty($allMenu[$menu->getId()]))
                @include('admin.menu.list.item', ['allMenu' => $allMenu, 'menus' => $allMenu[$menu->getId()]])
            @endif

        </li>
    @endforeach
</ol>