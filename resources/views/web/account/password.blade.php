@extends('web.layouts.account', [
    'browserTitle' => $title,
    'bodyClass' => 'account-password'
])

@section('accountContent')
    <form class="form-horizontal form-validation" action="{{ route('web.password.update') }}" method="post" enctype="multipart/form-data">
        {{ method_field('PATCH') }}

        {{ csrf_field() }}

        @component('web.shared.form.form-group')
            @slot('label') {{ __('passwords.current') }} @endslot
            @slot('input')
                @component('web.shared.input.text-component')
                    @slot('type') password @endslot
                    @slot('name') password_old @endslot
                    @slot('required') required @endslot
                    @slot('autofocus') autofocus @endslot
                @endcomponent
            @endslot
            @slot('more')
                @component('web.shared.form.help-text-component')
                    {{ __('passwords.provide_current') }}
                @endcomponent
            @endslot
        @endcomponent

        @component('web.shared.form.form-group')
            @slot('label') {{ __('passwords.new') }} @endslot
            @slot('input')
                @component('web.shared.input.text-component')
                    @slot('type') password @endslot
                    @slot('name') password @endslot
                    @slot('id') password @endslot
                    @slot('required') required @endslot
                    @slot('attributes')
                        minlength = "8"
                        maxlength = "20"
                    @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('web.shared.form.form-group')
            @slot('label') {{ __('passwords.confirm') }} @endslot
            @slot('input')
                @component('web.shared.input.text-component')
                    @slot('type') password @endslot
                    @slot('name') password_confirm @endslot
                    @slot('id') password_confirm @endslot
                    @slot('attributes')
                        minlength = "8"
                        maxlength = "20"
                        equalTo = "#password"
                        data-val-equalto = "{{ ucfirst(__('validation.same', ['attribute' => 'Confirm password', 'other' => 'Password'])) }}"
                    @endslot
                @endcomponent
            @endslot
        @endcomponent

        @include('web.shared.form.form-submit-button')
    </form>
@endsection
