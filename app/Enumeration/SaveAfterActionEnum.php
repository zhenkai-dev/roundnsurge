<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 28/1/2018
 * Time: 12:25 AM
 */

namespace App\Enumeration;


class SaveAfterActionEnum
{
    public const INSERT_NEW_RECORD = 'insert_new_record';
    public const BACK_TO_PREVIOUS = 'back_to_previous';
    public const CONTINUE_EDIT = 'continue_edit';
}