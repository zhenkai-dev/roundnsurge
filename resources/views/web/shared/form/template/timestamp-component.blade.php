<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 28/1/2018
 * Time: 12:22 AM
 */
?>

@php /* @var \Carbon\Carbon $updatedAt */ @endphp
@component('admin.shared.form.form-group-text')
    @slot('label') {{ __('common.updated_at') }} @endslot
    @slot('text') {{ $updatedAt->setTimezone(session('timezone'))->toDayDateTimeString() }} @endslot
@endcomponent

@php /* @var \Carbon\Carbon $createdAt */ @endphp
@if (!empty($createdAt))
    @component('admin.shared.form.form-group-text')
        @slot('label') {{ __('common.created_at') }} @endslot
        @slot('text') {{ $createdAt->setTimezone(session('timezone'))->toDayDateTimeString() }} @endslot
    @endcomponent
@endif
