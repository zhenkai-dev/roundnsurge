<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 21/1/2018
 * Time: 1:25 AM
 */
?>

<form name="form-filter" class="form-filter" action="{{ $action }}" method="get">
    <div class="form-row">
        {{ $inputs }}
    </div>

    <div class="form-row">
        <div class="form-group col-sm-6 order-sm-2 col-md text-right">
            <a href="{{ $action }}" class="btn btn-light btn-clear border">{{ __('common.clear') }}</a>
            <button type="submit" class="btn btn-filter btn-primary"><i class="fa fa-search"></i> {{ __('common.filter') }}</button>
        </div>
        <div class="form-group col-sm-6 order-sm-1 col-md">
            <div class="pull-left mr-3">
                {{ $pagination or '' }}
            </div>
            <div class="pull-left form-inline">
                @include('admin.shared.listing.page-size-component')
            </div>
        </div>
    </div>
</form>
