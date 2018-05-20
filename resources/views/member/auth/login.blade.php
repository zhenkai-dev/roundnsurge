@extends('member.layouts.auth')

@section('content')

<h1>{{ __('auth.login') }}</h1>
<p class="text-muted">{{ __('auth.login_description') }}</p>

<form class="form-horizontal form-validation" method="POST" action="{{ route('member.login') }}">
    {{ csrf_field() }}
    @php /* @var Illuminate\Support\ViewErrorBag $errors */ @endphp
    <div class="form-group{{ $errors->has('username') ? ' has-danger' : '' }}">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="icon-user"></i></span>
            </div>
            <input id="username" type="text" class="form-control" placeholder="{{ __('auth.username') }}" name="username" value="{{ old('username') }}" required autofocus>
        </div>
        <label class="text-danger" style="display: none" for="username"></label>

        @if ($errors->has('username'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('username') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
        <div class="input-group mb-4">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="icon-lock"></i></span>
            </div>
            <input id="password" type="password" class="form-control" placeholder="{{ __('auth.password') }}" name="password" required>
        </div>
        <label class="text-danger" style="display: none" for="password"></label>

        @if ($errors->has('password'))
            <span class="help-block text-danger">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>

    <div class="form-group d-none">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('auth.remember') }}
            </label>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <button type="submit" class="btn btn-primary px-4"><i class="icon icon-login"></i> {{ __('auth.login') }}</button>
        </div>
        <div class="col-6 text-right d-none">
            <a class="btn btn-link px-0" href="{{ route('member.password.request') }}">{{ __('auth.forgot') }}</a>
        </div>
    </div>
</form>
@endsection
