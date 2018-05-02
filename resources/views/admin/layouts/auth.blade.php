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

    <!-- Main styles for this application -->
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
</head>
<body class="app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card-group mb-0">
                    <div class="card p-4">
                        <div class="card-block">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin/js/script.js') }}"></script>

    <script>
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
    </script>

    @yield('scripts')
</body>
</html>
