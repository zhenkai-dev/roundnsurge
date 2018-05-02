<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 14/4/2018
 * Time: 5:19 PM
 */
?>

@component('admin.shared.input.select-component')
    @slot('name') url_id @endslot
    @slot('id') url_id @endslot
    @slot('option')
        <option value="">{{ __('common.select_with_hyphen') }}</option>
        @foreach(get_url_list() as $friendlyUrlGroupKey => $friendlyUrlGroup)
            <optgroup label="{{ trans_choice('entity.' . $friendlyUrlGroupKey, 2) }}">
                @foreach ($friendlyUrlGroup as $friendlyUrl)
                    <option value="{{ $friendlyUrl['id'] }}" {{ (is_edit() && $urlId == $friendlyUrl['id'] ? 'selected' : '') }}>{{ $friendlyUrl['name'] }}</option>
                @endforeach
            </optgroup>
        @endforeach
    @endslot
@endcomponent

<div class="form-check mt-2">
    <label>
        <input class="form-check-input" type="checkbox" name="external" value="1" data-name="external"> Link to external page
    </label>
</div>

<div class="d-none" data-name="externalLinkWrap">
    @component('admin.shared.input.textarea-component')
        @slot('name') url @endslot
        @slot('value') {{ old('url', (is_edit() ? $url : '')) }} @endslot
    @endcomponent
</div>
