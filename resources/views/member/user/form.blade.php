@extends('member.layouts.app-form')

@section('heading')
    {!! $title !!}
@endsection

@section('form')

    @component('member.shared.form.form-header-component', ['module' => \App\User::class])
        @slot('addNewUrl') {{ route('member.user.create') }}  @endslot
    @endcomponent

    @php /* @var \App\User $user */ @endphp
    <form class="form-horizontal form-validation" action="{{ is_create() ? route('member.user.store') : route('member.user.update', $user->id) }}" method="post" enctype="multipart/form-data">
        @if (is_edit())
            {{ method_field('PATCH') }}
        @endif

        {{ csrf_field() }}

        @component('member.shared.form.form-group')
            @slot('label') {{ __('user.name') }} @endslot
            @slot('input')
                @component('member.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') name @endslot
                    @slot('value') {{ old('name', (is_edit() ? $user->getName() : '')) }} @endslot
                    @slot('required') required @endslot
                    @slot('autofocus') autofocus @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('user.email') }} @endslot
            @slot('input')
                @component('member.shared.input.text-component')
                    @slot('type') email @endslot
                    @slot('name') email @endslot
                    @slot('value') {{ old('email', (is_edit() ? $user->getEmail() : '')) }} @endslot
                    @slot('required') required @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('user.username') }} @endslot
            @slot('input')
                @component('member.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') username @endslot
                    @slot('value') {{ old('username', (is_edit() ? $user->getUsername() : '')) }} @endslot
                    @slot('required') required @endslot
                    @slot('attributes')
                        alphanumeric = "true"
                        minlength = "5"
                        maxlength = "50"
                    @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('user.password') }} @endslot
            @slot('input')
                @component('member.shared.input.text-component')
                    @slot('type') password @endslot
                    @slot('name') password @endslot
                    @slot('id') password @endslot
                    @if (is_create())
                        @slot('required') required @endslot
                    @endif
                    @slot('attributes')
                        minlength = "8"
                        maxlength = "20"
                    @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('user.password_confirm') }} @endslot
            @slot('input')
                @component('member.shared.input.text-component')
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

        @component('member.shared.form.form-group')
            @slot('label') {{ __('user.module') }} @endslot
            @slot('input')
                {{ __('user.module_description') }}

                <div>
                    @foreach(config('app.modules') as $module => $enabled)
                        @if ($enabled)
                            @component('member.shared.input.bootstrap.checkbox-component', [
                                'checked' => (!empty($userHasModules) ? in_array($module, $userHasModules) : '')
                            ])
                                @slot('label') {{ trans_choice('entity.' . $module, 2) }} @endslot
                                @slot('name') modules[] @endslot
                                @slot('value') {{ $module }} @endslot
                            @endcomponent
                        @endif
                    @endforeach
                </div>
            @endslot
        @endcomponent

        @component('member.shared.form.form-group')
            @slot('label') {{ __('common.status') }} @endslot
            @slot('input')
                @component('member.shared.input.template.status-component', [
                    'value' => old('is_active', (is_edit() ? $user->isActive() : ''))
                ])
                    @slot('name') is_active @endslot
                @endcomponent
            @endslot
        @endcomponent

        @if (is_edit())
            @include('member.shared.form.template.timestamp-component',
            [
                'updatedAt' => $user->getUpdatedAt(),
                'createdAt' => $user->getCreatedAt(),
            ])
        @endif

        @include('member.shared.form.template.save-after-action-component')

        @include('member.shared.form.form-submit-button')
    </form>
@endsection
