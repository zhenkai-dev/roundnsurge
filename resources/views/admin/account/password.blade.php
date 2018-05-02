@extends('admin.layouts.app-form')

@section('heading')
    {!! $title !!}
@endsection

@section('form')
    <form class="form-horizontal form-validation" action="{{ route('admin.password.update') }}" method="post" enctype="multipart/form-data">
        {{ method_field('PATCH') }}

        {{ csrf_field() }}

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('passwords.current') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
                    @slot('type') password @endslot
                    @slot('name') password_old @endslot
                    @slot('required') required @endslot
                @endcomponent
            @endslot
            @slot('more')
                @component('admin.shared.form.help-text-component')
                    {{ __('passwords.provide_current') }}
                @endcomponent
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('passwords.new') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
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

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('passwords.confirm') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
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

        @include('admin.shared.form.form-submit-button')
    </form>
@endsection
