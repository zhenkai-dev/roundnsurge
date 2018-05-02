@extends('admin.layouts.app-form')

@section('heading')
    {!! $title !!}
@endsection

@section('form')
    @php /* @var \App\User $user */ @endphp
    <form class="form-horizontal form-validation" action="{{ route('admin.account.update') }}" method="post" enctype="multipart/form-data">
        {{ method_field('PATCH') }}

        {{ csrf_field() }}

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('user.name') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') name @endslot
                    @slot('value') {{ old('name', $user->getName()) }} @endslot
                    @slot('required') required @endslot
                    @slot('autofocus') autofocus @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('user.email') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
                    @slot('type') email @endslot
                    @slot('name') email @endslot
                    @slot('value') {{ old('email', $user->getEmail()) }} @endslot
                    @slot('required') required @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('user.username') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') username @endslot
                    @slot('value') {{ old('username', $user->getUsername()) }} @endslot
                    @slot('required') required @endslot
                    @slot('attributes')
                        alphanumeric = "true"
                        minlength = "5"
                        maxlength = "50"
                    @endslot
                @endcomponent
            @endslot
        @endcomponent

        @include('admin.shared.form.template.timestamp-component',
        [
            'updatedAt' => $user->getUpdatedAt(),
            'createdAt' => $user->getCreatedAt(),
        ])

        @include('admin.shared.form.form-submit-button')
    </form>
@endsection
