<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 12/1/2018
 * Time: 8:53 AM
 */
?>

<div class="row mb-3">
    <div class="col">
        {{ __('common.total_records', ['total' => $total]) }}
    </div>
    <div class="col text-right">
        @can(!empty($addNewUrl) && \App\Enumeration\PolicyActionEnum::CREATE, $module)
            {!! add_new_button($addNewUrl) !!}
        @endcan
    </div>
</div>
