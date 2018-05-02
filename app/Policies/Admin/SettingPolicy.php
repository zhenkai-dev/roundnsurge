<?php

namespace App\Policies\Admin;

use App\Enumeration\RolePermissionEnum;
use App\User;
use App\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    public $module = 'setting';

    /**
     * Determine whether is admin
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user): ?bool
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
     * @param  \App\User $user
     * @return bool
     */
    public function index(User $user): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_VIEW);
    }

    /**
     * Determine whether the setting can view the model.
     *
     * @param  \App\User $user
     * @param  \App\Setting $model
     * @return bool
     */
    public function view(User $user, Setting $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_VIEW);
    }

    /**
     * Determine whether the setting can create models.
     *
     * @param  \App\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_INSERT);
    }

    /**
     * Determine whether the setting can update the model.
     *
     * @param  \App\User $user
     * @param  \App\Setting $model
     * @return bool
     */
    public function update(User $user, Setting $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_UPDATE);
    }

    /**
     * Determine whether the setting can delete the model.
     *
     * @param  \App\User $user
     * @param  \App\Setting $model
     * @return bool
     */
    public function delete(User $user, Setting $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_DELETE);
    }
}
