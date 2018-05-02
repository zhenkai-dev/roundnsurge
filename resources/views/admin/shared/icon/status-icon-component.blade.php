<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 8/1/2018
 * Time: 8:45 AM
 */
?>

@if ($status === true)
    <span class="text-success" title="{{ __('common.active') }}"><i class="fa fa-check"></i></span>
@else
    <span class="text-danger" title="{{ __('common.disabled') }}"><i class="fa fa-times"></i></span>
@endif
