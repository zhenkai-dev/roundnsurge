@extends('web.layouts.app', [
    'bodyClass' => 'auth-register'
])

@php
    /* @var \App\Page $registerPage */
    /* @var \App\FriendlyUrl $termsUrl */
@endphp

@section('content')
    <div class="container">
        <div class="row justify-content-center my-5">
            <div class="col-md-7 left-content">
                <div class="content">
                    {!! editor_content($registerPage->pageTranslation->getDescription()) !!}
                </div>
            </div>
            <div class="col-md-5 right-content">
                <div class="content">
                    <h1 class="card-title">SIGN UP</h1>

                    @php /* @var \Illuminate\Support\ViewErrorBag $errors */ @endphp
                    @if (count($errors))
                        @component('web.shared.alert-component')
                            @slot('type') danger @endslot

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @endcomponent
                    @elseif (count(session('status')))
                        @component('web.shared.alert-component')
                            @slot('type') success @endslot

                            {{ session('status') }}
                        @endcomponent
                    @endif

                    <p>Already have an account? <a href="{{ route('web.login') }}">Log in</a></p>

                    <form class="form-horizontal form-register" method="POST" action="{{ route('web.register') }}">
                        {{ csrf_field() }}

                        @php /* @var Illuminate\Support\ViewErrorBag $errors */ @endphp
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="control-label">{{ __('member.name') }}</label>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">{{ __('member.email') }}</label>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        {{--<div class="form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                            <label for="dob" class="control-label">{{ __('member.dob') }}</label>
                            <input id="dob" type="text" class="form-control" name="dob" data-name="datepicker" value="{{ old('dob') }}" required>

                            @if ($errors->has('dob'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('dob') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                            <label for="mobile" class="control-label">{{ __('member.mobile') }}</label>
                            <input id="mobile" type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" required>

                            @if ($errors->has('mobile'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('mobile') }}</strong>
                                </span>
                            @endif
                        </div>--}}

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="control-label">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="acceptTerms" id="acceptTerms" value="1" required>
                                    I accept the <a href="{{ route('web.pages.show', ['slug' => $termsUrl->getName()]) }}" target="_blank">terms of service</a>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="package" value="{{ request('package') }}">

                            <button type="submit" class="btn btn-block btn-theme">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('.form-register').each(function () {
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