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
                        <button class="btn btn-red btn-consultation text-uppercase px-3 d-sm-block" type="button" data-toggle="modal" data-target="#modalContact">Request Consultation</button>
                    </div>
                </div>
            </nav>
        </header>

        <main id="main-container">
            @yield('content')
        </main>

        <footer>
            <div class="wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7 py-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <ul class="list-unstyled">
                                        <li><a href="">Team</a></li>
                                        <li><a href="">Our Clients</a></li>
                                        <li><a href="">Services</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-8 pr-5">
                                    <h4>About OWL</h4>
                                    <p>OWL is a digital consulting firm that offers a full range of
                                        consulting services from web system development,
                                        eCommerce, branding and creative development,
                                        marketing services and omni-channel integration that
                                        move from retail to online business.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="box-right py-5 pl-5">
                                <h4>Our Office</h4>
                                <address class="mb-3">
                                    LEVEL 6.06 KPMG TOWER,<br />
                                    8, FIRST AVENUE, BANDAR UTAMA,<br />
                                    47800 PJ, SELANGOR, MALAYSIA
                                </address>

                                <div><a href="mailto:hoot@owl.my">hoot@owl.my</a></div>
                                <div>Hotline :  +6017 888 1055</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <div id="modalContact" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form id="formContact" class="form" action="{{ route('web.enquiry.submit') }}" method="post">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <h3 class="text-center text-theme my-4">Ready to take your business to the next level ?</h3>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Your name</label>
                                    @component('shared.input.text-component')
                                        @slot('type') text @endslot
                                        @slot('name') name @endslot
                                        @slot('required') required @endslot
                                    @endcomponent
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Your email address</label>
                                    @component('shared.input.text-component')
                                        @slot('type') email @endslot
                                        @slot('name') email @endslot
                                        @slot('required') required @endslot
                                    @endcomponent
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Your phone number</label>
                                    @component('shared.input.text-component')
                                        @slot('type') text @endslot
                                        @slot('name') phone @endslot
                                        @slot('required') required @endslot
                                    @endcomponent
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Your company name (optional)</label>
                                    @component('shared.input.text-component')
                                        @slot('type') text @endslot
                                        @slot('name') company @endslot
                                    @endcomponent
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>What do you want us to help?</label>
                            @component('shared.input.select-component')
                                @slot('name') subject @endslot
                                @slot('required') required @endslot
                                @slot('option')
                                    <option value="Build a website">Build a website</option>
                                @endslot
                            @endcomponent
                        </div>
                        <div class="form-group">
                            <label>How much is your budget?</label>
                            @component('shared.input.select-component')
                                @slot('name') budget @endslot
                                @slot('required') required @endslot
                                @slot('option')
                                    <option value="RM 3,000 - RM 5,000">RM 3,000 - RM 5,000</option>
                                @endslot
                            @endcomponent
                        </div>
                        <div class="form-group">
                            <label>Please provide a short description of your project</label>
                            @component('shared.input.textarea-component')
                                @slot('name') description @endslot
                                @slot('required') required @endslot
                                @slot('class') autosize @endslot
                            @endcomponent
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fa fa-envelope"></i> Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
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