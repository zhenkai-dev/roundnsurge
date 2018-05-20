<?php

namespace App\Policies\Member;

use App\Enumeration\RolePermissionEnum;
use App\Member;
use App\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    public $module = 'setting';

    /**
     * Determine whether is admin
     *
     * @param Member $user
     * @return bool
     */
    public function before(Member $user): ?bool
    {
        if (config('app.modules.setting') != true) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the setting can view listing of the models.
     *
     * @param  \App\Member $user
     * @return bool
     */
    public function index(Member $user): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_VIEW);
    }

    /**
     * Determine whether the setting can view the model.
     *
     * @param  \App\Member $user
     * @param  \App\Setting $model
     * @return bool
     */
    public function view(Member $user, Setting $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_VIEW);
    }

    /**
     * Determine whether the setting can create models.
     *
     * @param  \App\Member $user
     * @return bool
     */
    public function create(Member $user): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_INSERT);
    }

    /**
     * Determine whether the setting can update the model.
     *
     * @param  \App\Member $user
     * @param  \App\Setting $model
     * @return bool
     */
    public function update(Member $user, Setting $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_UPDATE);
    }

    /**
     * Determine whether the setting can delete the model.
     *
     * @param  \App\Member $user
     * @param  \App\Setting $model
     * @return bool
     */
    public function delete(Member $user, Setting $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_DELETE);
    }
}
