<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 6/4/2018
 * Time: 1:40 PM
 */
?>

@php
    /* @var \App\Menu[] $menus */
    /**
    * $menu with [menu_name, friendly_url_name, friendly_url_module]
    */
@endphp
@foreach($menus as $menu)
    @if (!empty($menuGrouped[$menu->getId()]))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="{{ get_site_url(new \App\Dto\UrlDto($menu['friendly_url_id'], $menu['friendly_url_name'], $menu['friendly_url_module'], $menu->getUrl())) }}" target="{{ $menu->getTarget() }}">
                {{ $menu['menu_name'] }}
            </a>

            <span class="mobile-toggle d-flex justify-content-center align-items-center" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></span>

            <ul class="dropdown-menu">
                @component('web.shared.menu.dropdown-menu-item-component', ['menus' => $menuGrouped[$menu->getId()], 'menuGrouped' => $menuGrouped])
                @endcomponent
            </ul>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link" href="{{ get_site_url(new \App\Dto\UrlDto($menu['friendly_url_id'], $menu['friendly_url_name'], $menu['friendly_url_module'], $menu->getUrl())) }}" target="{{ $menu->getTarget() }}">{{ $menu['menu_name'] }}</a>
        </li>
    @endif
@endforeach
