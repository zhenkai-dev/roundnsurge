<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 14/4/2018
 * Time: 5:21 PM
 */
?>

<script>
    $('[data-name="external"]').change(function() {
        var $this = $(this);
        if ($this.is(':checked')) {
            $('#url_id').prop('disabled', true);
            $('[data-name="externalLinkWrap"]').removeClass('d-none');
            $('[name="url"]').prop('disabled', false);
            $('[name="url"]').focus();
        } else {
            $('#url_id').prop('disabled', false);
            $('[data-name="externalLinkWrap"]').addClass('d-none');
            $('[name="url"]').prop('disabled', true);
        }
    });

    if ($('[name="url"]').val() != '') {
        $('[data-name="external"]').trigger('click');
    }
</script>
