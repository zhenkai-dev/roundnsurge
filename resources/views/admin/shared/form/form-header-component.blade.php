<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 21/1/2018
 * Time: 10:38 PM
 */
?>

@can(\App\Enumeration\PolicyActionEnum::CREATE, $module)
    <div class="mb-3 text-right">
        {!! add_new_button($addNewUrl) !!}
    </div>
@endcan
