<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 28/1/2018
 * Time: 1:40 AM
 */
?>

<span class="mr-3">{{ __('common.show') }}</span>
@component('member.shared.input.select-component')
    @slot('name') pageSize @endslot
    @slot('class') input-sm @endslot
    @slot('attributes') data-name = "pageSize" @endslot
    @slot('option')
        @foreach(\App\Service\Admin\Util\PageSizeUtil::getPageSizeList() as $size)
            <option value="{{ $size }}" {{ \App\Service\Admin\Util\PageSizeUtil::getPageSize() == $size ? 'selected' : '' }}>{{ $size }}</option>
        @endforeach
    @endslot
@endcomponent
