<?php

namespace App\Policies\Admin;

use App\Enumeration\RolePermissionEnum;
use App\Package;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackagePolicy
{
    use HandlesAuthorization;

    public $module = 'package';

    /**
     * Determine whether is admin
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user): ?bool
    {
        if (config('app.modules.package') != true) {
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
     * @param  \App\User $user
     * @return bool
     */
    public function index(User $user): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_VIEW);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User $user
     * @param  \App\User $model
     * @return bool
     */
    public function view(User $user, Package $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_VIEW);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_INSERT);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User $user
     * @param  \App\User $model
     * @return bool
     */
    public function update(User $user, Package $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_UPDATE);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User $user
     * @param  \App\User $model
     * @return bool
     */
    public function delete(User $user, Package $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_DELETE);
    }
}
