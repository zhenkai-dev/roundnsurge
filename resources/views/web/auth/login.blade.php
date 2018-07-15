@extends('web.layouts.app', [
        'bodyClass' => 'auth auth-login'
        ])

@section('content')
<div class="container">
    <div class="row justify-content-center my-5 py-5">
        <div class="col-md-6 col-lg-4 mb-5 py-3">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-uppercase">LOG IN</h1>

                    <p class="description">Need an account? <a href="{{ route('web.register') }}">Sign up</a></p>

                    <form class="form-horizontal" method="POST" action="{{ route('web.login') }}">
                        {{ csrf_field() }}

                        @php /* @var Illuminate\Support\ViewErrorBag $errors */ @endphp
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="control-label">E-Mail Address</label>

                            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group d-none">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <a class="" href="{{ route('web.password.request') }}">
                                Forgot Your Password?
                            </a>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-theme btn-block">
                                <i class="fa fa-login"></i> LOG IN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
