<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 21/1/2018
 * Time: 10:50 PM
 */
?>

<div class="form-group row">
    <label class="col-md-3 col-form-label">{{ $label }}</label>
    <div class="col-md-9">
        {{ $input }}

        {!! $more or '' !!}
    </div>
</div>
