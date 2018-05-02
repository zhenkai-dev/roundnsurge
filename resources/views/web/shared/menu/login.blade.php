<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 23/4/2018
 * Time: 8:53 PM
 */
?>

<div class="my-2 my-lg-0 mr-3">
    @guest (config('auth.guards.web.name'))
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="{{ route('web.login') }}">Login</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('web.register') }}">Register</a></li>
        </ul>
    @endguest
    @auth (config('auth.guards.web.name'))
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"> {{ Auth::user()->getName() }} </a>
                <ul class="dropdown-menu">
                    <li class="nav-item">
                        <a class="dropdown-item" href="{{ route('web.account.index') }}">
                            <i class="fa fa-user fa-fw"></i> Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="{{ route('web.password.index') }}">
                            <i class="fa fa-key fa-fw"></i> Change password
                        </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <li class="nav-item">
                        <a class="dropdown-item" href="{{ route('web.logout') }}"
                           onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out fa-fw"></i> Logout
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('web.logout') }}"
                   onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                    Logout

                    <form id="logout-form" action="{{ route('web.logout') }}" method="POST" class="d-none">
                        {{ csrf_field() }}
                    </form>
                </a>
            </li>
        </ul>
    @endauth
</div>
