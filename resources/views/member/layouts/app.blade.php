<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    @yield('styles')

    <!-- Main styles for this application -->
    <link href="{{ asset('member/css/style.css') }}" rel="stylesheet">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">

<header class="app-header navbar">
    <button class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button">☰</button>
    <a class="navbar-brand" href="{{ route('member.home') }}"></a>
    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item">
            <a class="nav-link navbar-toggler sidebar-toggler" href="#">☰</a>
        </li>

        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('member.home') }}">{{ __('common.dashboard') }}</a>
        </li>

        @if (can_access_module(\App\User::class))
            <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('member.user.index') }}">{{ trans_choice('entity.user', 2) }}</a>
            </li>
        @endif

        @if (can_access_module(\App\Setting::class))
            <li class="nav-item px-3">
                <a class="nav-link" href="{{ route('member.setting.edit') }}">{{ trans_choice('entity.setting', 1) }}</a>
            </li>
        @endif
    </ul>
    <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown pr-3">
            <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="d-md-down-none">{{ Auth::user()->getName() }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">

                <div class="dropdown-header text-center">
                    <strong>{{ __('common.account') }}</strong>
                </div>

                <a class="dropdown-item" href="{{ route('member.account.index') }}"><i class="fa fa-user"></i> {{ __('account.profile') }}</a>
                <a class="dropdown-item" href="{{ route('member.account.membership') }}"><i class="fa fa-id-card-o"></i> {{ __('account.membership') }}</a>
                <a class="dropdown-item" href="{{ route('member.password.index') }}"><i class="fa fa-key"></i> {{ __('account.change_password') }}</a>
                <a class="dropdown-item" href="{{ route('member.logout') }}"
                   onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="fa fa-lock"></i> {{ __('account.logout') }}

                    <form id="logout-form" action="{{ route('member.logout') }}" method="POST" class="d-none">
                        {{ csrf_field() }}
                    </form>
                </a>
            </div>
        </li>

        <li class="nav-item pr-3">
            <a class="nav-link" href="{{ url('/') }}" target="_blank">
                <i class="icon-globe"></i> {{ __('common.view_official') }}
            </a>
        </li>
    </ul>
</header>

    <div class="app-body">
        <div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">

                    @component('member.shared.sidebar.item-component')
                        @slot('url') {{ route('member.home') }} @endslot
                        @slot('iconClass') icon-speedometer @endslot
                        @slot('text') {{ __('common.dashboard') }} @endslot
                    @endcomponent

                    @if (can_access_module(\App\Course::class))
                        @component('member.shared.sidebar.item-component')
                            @slot('url') {{ route('member.course.index') }} @endslot
                            @slot('iconClass') icon-book-open @endslot
                            @slot('text') {{ trans_choice('entity.course', 2) }} @endslot
                        @endcomponent
                    @endif

                    @if (can_access_module(\App\Package::class))
                        @component('member.shared.sidebar.item-component')
                            @slot('url') {{ route('member.package.index') }} @endslot
                            @slot('iconClass') icon-badge @endslot
                            @slot('text') {{ trans_choice('entity.package', 2) }} @endslot
                        @endcomponent
                    @endif

                    @if (can_access_module(\App\Page::class))
                        @component('member.shared.sidebar.item-component')
                            @slot('url') {{ route('member.page.index') }} @endslot
                            @slot('iconClass') icon-screen-desktop @endslot
                            @slot('text') {{ trans_choice('entity.page', 2) }} @endslot
                        @endcomponent
                    @endif

                    @if (can_access_module(\App\Menu::class))
                        @component('member.shared.sidebar.item-component')
                            @slot('url') {{ route('member.menu.index') }} @endslot
                            @slot('iconClass') icon-list @endslot
                            @slot('text') {{ trans_choice('entity.menu', 2) }} @endslot
                        @endcomponent
                    @endif

                    @if (can_access_module(\App\Banner::class))
                        @component('member.shared.sidebar.item-component')
                            @slot('url') {{ route('member.banner.index') }} @endslot
                            @slot('iconClass') icon-picture @endslot
                            @slot('text') {{ trans_choice('entity.banner', 2) }} @endslot
                        @endcomponent
                    @endif

                    @if (can_access_module(\App\News::class))
                        @component('member.shared.sidebar.item-component')
                            @slot('url') {{ route('member.news.index') }} @endslot
                            @slot('iconClass') icon-book-open @endslot
                            @slot('text') {{ trans_choice('entity.news', 2) }} @endslot
                        @endcomponent
                    @endif

                    @if (can_access_module(\App\Member::class))
                        @component('member.shared.sidebar.item-component')
                            @slot('url') {{ route('member.member.index') }} @endslot
                            @slot('iconClass') icon-people @endslot
                            @slot('text') {{ trans_choice('entity.member', 2) }} @endslot
                        @endcomponent
                    @endif

                    @if (can_access_module(\App\User::class))
                        @component('member.shared.sidebar.item-component')
                            @slot('url') {{ route('member.user.index') }} @endslot
                            @slot('iconClass') icon-user @endslot
                            @slot('text') {{ trans_choice('entity.user', 2) }} @endslot
                        @endcomponent
                    @endif

                    @if (can_access_module(\App\Setting::class))
                        @component('member.shared.sidebar.item-component')
                            @slot('url') {{ route('member.setting.edit') }} @endslot
                            @slot('iconClass') icon-settings @endslot
                            @slot('text') {{ trans_choice('entity.setting', 1) }} @endslot
                        @endcomponent
                    @endif
                </ul>
            </nav>
        </div>

        <!-- Main content -->
        <main class="main">

            <!-- Breadcrumb -->
            {!! Breadcrumbs::render() !!}

            <div class="container-fluid">

                <div class="animated fadeIn">
                    @yield('content')
                </div>
            </div>
            <!-- /.conainer-fluid -->
        </main>
    </div>

    <footer class="app-footer">
        <a href="http://owl.my">Owl.My</a> © 2017. <span class="pull-right"> Powered by <a href="http://owl.my">Owl.My</a></span>
    </footer>

    @include('member.shared.delete-dialog-component')

    @yield('popup-dialog')

    <!-- Scripts -->
    <script src="{{ asset('member/js/script.js') }}"></script>

    <!-- Custom scripts required by this view -->
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.form-validation').each(function () {
                var $form = $(this);
                $form.validate({
                    errorClass: 'text-danger',
                    submitHandler: function (form) {
                        $("*[type=submit]").attr("disabled", true);
                        $(form).find('[type=submit]').button('loading');
                        form.submit();
                    }
                });

                inputAddRules($form);
            });

            var $modalDelete = $('#modalDelete');
            $modalDelete.on('show.bs.modal', function(e) {
                var $this = $(this);
                $this.find('form').attr('action', e.relatedTarget.href);
            });

            $modalDelete.find('[type="submit"]').on('click', function() {
                $(this).button('loading');
            });

            $('body').on('click', '[data-name="changeStatus"]', function () {
                var $this = $(this);
                var url = $this.attr('data-url');
                var value = $this.attr('data-to');
                var $loading = $('<i class="fa fa-pulse fa-spinner"></i>');
                $.ajax({
                    type: 'PATCH', url: url, dataType: 'json', data: {'status': value},
                    beforeSend: function (data) {
                        $this.replaceWith($loading);
                    },
                    success: function (data) {
                        if (data.result === true) {
                            $loading.replaceWith(data.html);
                        }
                    }
                });
            });

            $('[data-name="pageSize"]').change(function () {
                var $this = $(this);
                var value = $this.val();
                $.ajax({
                    type: 'POST', url: '{{ route('member.setting.updatePageSize') }}', dataType: 'json', data : { 'pageSize': value },
                    complete: function () {
                        window.location.href = removeURLParameter(window.location.href, 'page');
                    }
                });
            });

            $.ajax({
                type: 'POST', url: '{{ route('member.setting.updateClientTimezone') }}', dataType: 'json', data : { 'timezone': moment.tz.guess() }
            });

            $('[data-name="disableTarget"]').change(function() {
                var $this = $(this);
                if ($this.is(':checked')) {
                    $($this.data('target')).prop('disabled', true);
                } else {
                    $($this.data('target')).prop('disabled', false);
                }
            });

            $.fn.singleDatePicker = function() {
                $(this).on("apply.daterangepicker", function(e, picker) {
                    picker.element.val(picker.startDate.format(picker.locale.format));
                });
                return $(this).daterangepicker({
                    singleDatePicker: true,
                    autoUpdateInput: false,
                    showDropdowns: true
                });
            };

            $('input[data-name="datepicker"]').singleDatePicker();

            autosize(document.querySelectorAll('textarea.autosize'));
        });

        function dialogErrorWrapper(messages) {
            return '<div class="alert alert-danger alert-dismissable">' +
                '<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>' +
                '<ul class="list-unstyled mb-0">' + messages + '</ul>' +
            '</div>';
        }
    </script>

    @yield('scripts')
</body>
</html>
