<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="keywords" content="{{ (!empty($metaKeywords) ? $metaKeywords : setting()->getDefaultMetaKeywords()) }}">
    <meta name="description" content="{{ (!empty($metaDescription) ? $metaDescription : setting()->getDefaultMetaDescription()) }}">
    <meta itemprop="name" content="{{ (!empty($browserTitle) ? config('app.name', 'Laravel') : '') }}">
    <meta itemprop="description" content="{{ (!empty($metaDescription) ? $metaDescription : setting()->getDefaultMetaDescription()) }}">
    <meta itemprop="image" content="{{ url(get_social_cover()) }}">
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:creator" content="@author_handle">
    <meta property="og:title" content="{{ (!empty($browserTitle) ? $browserTitle : setting()->getSiteName()) }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ url(get_social_cover()) }}">
    <meta property="og:site_name" content="{{ setting()->getSiteName() }}">
    <meta property="og:description" content="{{ (!empty($metaDescription) ? $metaDescription : setting()->getDefaultMetaDescription()) }}">

    <title>{{ (!empty($browserTitle) ? $browserTitle : setting()->getSiteName()) }}</title>

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    @yield('styles')

    <!-- Main styles for this application -->
    <link href="{{ asset('web/css/style.css') }}" rel="stylesheet">

    @if (setting()->getEmbedScriptTop())
        {!! setting()->getEmbedScriptTop() !!}
    @endif
</head>
<body class="{{ $bodyClass or '' }}">
    <div class="wrapper">
        <header>
            <nav class="navbar navbar-expand-md">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="img-fluid" title="{{ setting()->getSiteName() }}" alt="{{ setting()->getSiteName() }}" src="{{ get_logo() }}">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMainMenu" aria-controls="navbarMainMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMainMenu">
                    <div class="mr-auto"></div>
                    @if (count($menuGrouped))
                        <ul id="menu" class="navbar-nav">
                            @component ('web.shared.menu.menu-item-component', ['menus' => $menuGrouped[0], 'menuGrouped' => $menuGrouped])
                            @endcomponent
                        </ul>
                    @endif
                    @component('web.shared.menu.login')
                    @endcomponent
                    <div class="my-2 my-lg-0">
                        <button class="btn btn-theme px-3 d-sm-block" type="button" target="_blank">Sign Up</button>
                    </div>
                </div>
            </nav>
        </header>

        <main id="main-container">
            @yield('content')
        </main>

        <footer>
            <div class="wrapper py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-lg-9 footer-left">
                            <div class="row">
                                <div class="col-sm-6 col-md-5 col-lg-3">
                                    <div class="social">
                                        <div class="social-heading">Stay Connected</div>
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><a href=""><i class="fa fa-facebook"></i></a></li>
                                            <li class="list-inline-item"><a href=""><i class="fa fa-instagram"></i></a></li>
                                            <li class="list-inline-item"><a href=""><i class="fa fa-youtube"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-7 col-lg-9">
                                    <ul class="footer-link">
                                        <li><a href="">Training</a></li>
                                        <li><a href="">Blog</a></li>
                                        <li><a href="">About</a></li>
                                        <li><a href="">Resources</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3 footer-right">
                            <h5 class="text-theme">Contact Us</h5>
                            <div class="phone mb-3">+6019 556 7829</div>
                            <div class="mb-3"><a href="mailto:roundnsurge@gmail.com">roundnsurge@gmail.com</a></div>
                            <address>
                                19-2A, Jalan PJU 1/3C.<br />
                                Petaling Jaya, Malaysia 47801
                            </address>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @yield('modals')

    <!-- Scripts -->
    <script src="{{ asset('web/js/script.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#formContact').each(function () {
                var $form = $(this);
                $form.validate({
                    errorClass: 'text-danger',
                    submitHandler: function (form) {
                        $("*[type=submit]").attr("disabled", true);
                        $(form).find('[type=submit]').button('loading');

                        var input = {};
                        var $this = $(form);
                        var url = $this.attr('action');
                        var method = $this.attr('method');

                        $.each($this.serializeArray(), function (i, field) {
                            input[field.name] = field.value;
                        });

                        $.ajax({
                            type: 'POST', url: url, dataType: 'json', data: input,
                            beforeSend: function (xhr) {
                                $this.find('[type="submit"]').attr('disabled', true);
                                $this.find('[type=submit]').button('loading');
                            },
                            success: function (data) {
                                alert('Your enquiry has been submitted successfully.');
                                $this[0].reset();
                                $('#modalContact').modal('hide');
                            },
                            complete: function(data) {
                                $this.find('[type="submit"]').attr('disabled', false);
                                $this.find('[type=submit]').button('reset');
                            }
                        });
                    }
                });

                inputAddRules($form);
            });

            $('#modalContact').on('shown.bs.modal', function() {
                $('#formContact').find('[name="name"]').focus();
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

            autosize(document.querySelectorAll('textarea.autosize'));

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
        });
    </script>
    @yield('scripts')

    @if (setting()->getEmbedScriptBottom())
        {!! setting()->getEmbedScriptBottom() !!}
    @endif
</body>
</html>