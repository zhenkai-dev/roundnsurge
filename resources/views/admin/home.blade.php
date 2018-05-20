@extends('admin.layouts.app')

@section('content')
    <div class="home-quicklinks">
        <div class="row">

            @if (can_access_module(\App\Page::class))
                <div class="col-sm-2">
                    <div class="card shadow-sm">
                        <a href="{{ route('admin.page.index') }}">
                            <div class="card-body">
                                <div class="icon"><i class="icon-screen-desktop"></i></div>
                                <h3 class="text-center">{{ trans_choice('entity.page', 2) }}</h3>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

            @if (can_access_module(\App\Menu::class))
                <div class="col-sm-2">
                    <div class="card shadow-sm">
                        <a href="{{ route('admin.menu.index') }}">
                            <div class="card-body">
                                <div class="icon"><i class="icon-list"></i></div>
                                <h3 class="text-center">{{ trans_choice('entity.menu', 2) }}</h3>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

            @if (can_access_module(\App\Banner::class))
                <div class="col-sm-2">
                    <div class="card shadow-sm">
                        <a href="{{ route('admin.banner.index') }}">
                            <div class="card-body">
                                <div class="icon"><i class="icon-picture"></i></div>
                                <h3 class="text-center">{{ trans_choice('entity.banner', 2) }}</h3>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

            @if (can_access_module(\App\News::class))
                <div class="col-sm-2">
                    <div class="card shadow-sm">
                        <a href="{{ route('admin.news.index') }}">
                            <div class="card-body">
                                <div class="icon"><i class="icon-book-open"></i></div>
                                <h3 class="text-center">{{ trans_choice('entity.news', 2) }}</h3>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

            @if (can_access_module(\App\Member::class))
                <div class="col-sm-2">
                    <div class="card shadow-sm">
                        <a href="{{ route('admin.member.index') }}">
                            <div class="card-body">
                                <div class="icon"><i class="icon-people"></i></div>
                                <h3 class="text-center">{{ trans_choice('entity.member', 2) }}</h3>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

            @if (can_access_module(\App\User::class))
                <div class="col-sm-2">
                    <div class="card shadow-sm">
                        <a href="{{ route('admin.user.index') }}">
                            <div class="card-body">
                                <div class="icon"><i class="icon-user"></i></div>
                                <h3 class="text-center">{{ trans_choice('entity.user', 2) }}</h3>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

            @if (can_access_module(\App\Setting::class))
                <div class="col-sm-2">
                    <div class="card shadow-sm">
                        <a href="{{ route('admin.setting.edit') }}">
                            <div class="card-body">
                                <div class="icon"><i class="icon-settings"></i></div>
                                <h3 class="text-center">{{ trans_choice('entity.setting', 2) }}</h3>
                            </div>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('member/js/chart.min.js') }}"></script>
@endsection
