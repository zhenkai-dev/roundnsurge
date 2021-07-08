<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 26/4/2018
 * Time: 9:34 PM
 */
?>

@extends('web.layouts.app')

@section('content')
    <div class="container">
        <div class="py-5">
            <div class="row">
                <div class="col-md-4 d-none d-md-block">
                    <div class="list-group">
                        <a href="{{ route('web.account.index') }}" class="list-group-item list-group-item-action
                            {{ (URL::current() == route('web.account.index') ? 'active' : '') }}">
                            <i class="fa fa-user fa-fw"></i> Profile
                        </a>
                        <a href="{{ route('web.password.index') }}" class="list-group-item list-group-item-action
                            {{ (starts_with(URL::current(), route('web.password.index')) ? 'active' : '') }}">
                            <i class="fa fa-key fa-fw"></i> Change password
                        </a>
                        <a href="{{ route('web.account.address') }}" class="list-group-item list-group-item-action
                            {{ (starts_with(URL::current(), route('web.account.address')) ? 'active' : '') }}">
                            <i class="fa fa-address-book fa-fw"></i> Address
                        </a>
                        <a href="{{ route('web.logout') }}" class="list-group-item list-group-item-action"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form-2').submit();">

                            <form id="logout-form-2" action="{{ route('web.logout') }}" method="POST" class="d-none">
                                {{ csrf_field() }}
                            </form>

                            <i class="fa fa-sign-out fa-fw"></i> Logout
                        </a>
                    </div>
                </div>
                <div class="col-md-8">

                    <h2>{{ $title }}</h2>

                    @php /* @var \Illuminate\Support\ViewErrorBag $errors */ @endphp
                    @if (count($errors))
                        @component('web.shared.alert-component')
                            @slot('type') danger @endslot

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @endcomponent
                    @elseif (session('status'))
                        @component('web.shared.alert-component')
                            @slot('type') success @endslot

                            {{ session('status') }}
                        @endcomponent
                    @endif

                    @yield('accountContent')
                </div>
            </div>
        </div>
    </div>
@endsection
