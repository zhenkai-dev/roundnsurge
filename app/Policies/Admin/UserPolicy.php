<?php

namespace App\Policies\Admin;

use App\Enumeration\RolePermissionEnum;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public $module = 'user';

    /**
     * Determine whether is admin
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user): ?bool
    {
        if (config('app.modules.user') != true) {
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
    public function view(User $user, User $model): bool
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
    public function update(User $user, User $model): bool
    {
        if ($model->getId() != \Auth::id() && $model->getId() != 1) {
            return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_UPDATE);
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User $user
     * @param  \App\User $model
     * @return bool
     */
    public function delete(User $user, User $model): bool
    {
        if ($model->getId() != \Auth::id() && $model->getId() != 1) {
            return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_DELETE);
        }
        return false;
    }
}
