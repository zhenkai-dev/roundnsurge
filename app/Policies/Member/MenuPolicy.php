<?php

namespace App\Policies\Member;

use App\Enumeration\RolePermissionEnum;
use App\Menu;
use App\Member;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    public $module = 'menu';

    /**
     * Determine whether is admin
     *
     * @param Member $user
     * @return bool
     */
    public function before(Member $user): ?bool
    {
        if (config('app.modules.menu') != true) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the user can view listing of the models.
     *
     * @param  \App\Member $user
     * @return bool
     */
    public function index(Member $user): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Member $user
     * @param  \App\Member $model
     * @return bool
     */
    public function view(Member $user, Menu $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_VIEW);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Member $user
     * @return bool
     */
    public function create(Member $user): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_INSERT);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Member $user
     * @param  \App\Member $model
     * @return bool
     */
    public function update(Member $user, Menu $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_UPDATE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Member $user
     * @param  \App\Member $model
     * @return bool
     */
    public function delete(Member $user, Menu $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_DELETE);
    }
}
