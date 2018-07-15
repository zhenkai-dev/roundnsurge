@extends('web.layouts.app', [
        'bodyClass' => 'auth auth-password-email'
        ])

@section('content')
<div class="container">
    <div class="row justify-content-center my-5 py-5">
        <div class="col-md-6 col-lg-4 mb-5 py-3">
            <div class="card">
                <div class="card-body">
                    @php /* @var Illuminate\Support\ViewErrorBag $errors */ @endphp
                    <h1 class="card-title text-uppercase">Reset Password</h1>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="description">We will send you an email to reset your password.</p>

                    <form class="form-horizontal" method="POST" action="{{ route('web.password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">Email</label>

                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div>
                            <button type="submit" class="btn btn-block btn-theme text-uppercase">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $('form').each(function () {
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
@endsection