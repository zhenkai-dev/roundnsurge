<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 21/4/2018
 * Time: 9:31 AM
 */
?>

@component('admin.shared.input.text-group-component')
    @slot('addonLeft') {{ $urlPath }} @endslot
    @slot('type') text @endslot
    @slot('name') url_name @endslot
    @slot('value') {{ $value }} @endslot
    @slot('required') required @endslot
    @slot('addonRight') <a href="{{ $previewUrl }}" target="_blank"><i class="fa fa-share"></i></a> @endslot
@endcomponent
