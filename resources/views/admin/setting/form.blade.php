@extends('admin.layouts.app-form')

@section('heading')
    {!! $title !!}
@endsection

@section('form')
    @php /* @var \App\Setting $setting */ @endphp
    <form class="form-horizontal form-validation" action="{{ route('admin.setting.update') }}" method="post" enctype="multipart/form-data">
        @if (is_edit())
            {{ method_field('PATCH') }}
        @endif

        {{ csrf_field() }}

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('setting.site_name') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') site_name @endslot
                    @slot('value') {{ old('site_name', (is_edit() ? $setting->getSiteName() : '')) }} @endslot
                    @slot('required') required @endslot
                    @slot('autofocus') autofocus @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('setting.enquiry_receiver') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') enquiry_receiver @endslot
                    @slot('value') {{ old('enquiry_receiver', (is_edit() ? $setting->getEnquiryReceiver() : '')) }} @endslot
                    @slot('required') required @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('setting.default_meta_title') }} @endslot
            @slot('input')
                @component('admin.shared.input.text-component')
                    @slot('type') text @endslot
                    @slot('name') default_meta_title @endslot
                    @slot('value') {{ old('default_meta_title', (is_edit() ? $setting->getDefaultMetaTitle() : '')) }} @endslot
                @endcomponent
            @endslot
        @endcomponent

            @component('admin.shared.form.form-group')
                @slot('label') {{ __('setting.default_meta_keywords') }} @endslot
                @slot('input')
                    @component('admin.shared.input.textarea-component')
                        @slot('class') autosize @endslot
                        @slot('name') default_meta_keywords @endslot
                        @slot('value') {{ old('default_meta_keywords', (is_edit() ? $setting->getDefaultMetaKeywords() : '')) }} @endslot
                    @endcomponent
                @endslot
            @endcomponent

            @component('admin.shared.form.form-group')
                @slot('label') {{ __('setting.default_meta_description') }} @endslot
                @slot('input')
                    @component('admin.shared.input.textarea-component')
                        @slot('class') autosize @endslot
                        @slot('name') default_meta_description @endslot
                        @slot('value') {{ old('default_meta_description', (is_edit() ? $setting->getDefaultMetaDescription() : '')) }} @endslot
                    @endcomponent
                @endslot
            @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('setting.embed_script_top') }} @endslot
            @slot('input')
                @component('admin.shared.input.textarea-component')
                    @slot('class') autosize @endslot
                    @slot('name') embed_script_top @endslot
                    @slot('value') {{ old('embed_script_top', (is_edit() ? $setting->getEmbedScriptTop() : '')) }} @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('setting.embed_script_bottom') }} @endslot
            @slot('input')
                @component('admin.shared.input.textarea-component')
                    @slot('class') autosize @endslot
                    @slot('name') embed_script_bottom @endslot
                    @slot('value') {{ old('embed_script_bottom', (is_edit() ? $setting->getEmbedScriptBottom() : '')) }} @endslot
                @endcomponent
            @endslot
        @endcomponent

        @component('admin.shared.form.form-group')
            @slot('label') Maintenance Mode @endslot
            @slot('input')
                <select name="is_maintenance_mode" class="form-control">
                    <option value="0" @if(old('is_maintenance_mode', $setting->getIsMaintenanceMode()) == '0') selected @endif>No</option>
                    <option value="1" @if(old('is_maintenance_mode', $setting->getIsMaintenanceMode()) == '1') selected @endif>Yes</option>
                </select>
            @endslot
        @endcomponent

        @if (is_edit())
            @include('admin.shared.form.template.timestamp-component',
            [
                'updatedAt' => $setting->getUpdatedAt(),
            ])
        @endif

        @include('admin.shared.form.form-submit-button')
    </form>
@endsection
