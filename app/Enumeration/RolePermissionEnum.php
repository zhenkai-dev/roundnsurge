<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 21/1/2018
 * Time: 7:21 PM
 */

namespace App\Enumeration;


abstract class RolePermissionEnum
{
    const CAN_UPDATE = 'can_update';
    const CAN_INSERT = 'can_insert';
    const CAN_DELETE = 'can_delete';
    const CAN_VIEW = 'can_view';
}