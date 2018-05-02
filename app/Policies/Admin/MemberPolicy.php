<?php

namespace App\Policies\Admin;

use App\Enumeration\RolePermissionEnum;
use App\User;
use App\Member;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemberPolicy
{
    use HandlesAuthorization;

    public $module = 'member';

    /**
     * Determine whether is admin
     *
     * @param User $user
     * @return bool
     */
    public function before(User $user): ?bool
    {
        if (config('app.modules.member') != true) {
            return false;
        }

        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    /**
     * Determine whether the member can view listing of the models.
     *
     * @param  \App\User $user
     * @return bool
     */
    public function index(User $user): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_VIEW);
    }

    /**
     * Determine whether the member can view the model.
     *
     * @param  \App\User $user
     * @param  \App\Member $model
     * @return bool
     */
    public function view(User $user, Member $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_VIEW);
    }

    /**
     * Determine whether the member can create models.
     *
     * @param  \App\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_INSERT);
    }

    /**
     * Determine whether the member can update the model.
     *
     * @param  \App\User $user
     * @param  \App\Member $model
     * @return bool
     */
    public function update(User $user, Member $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_UPDATE);
    }

    /**
     * Determine whether the member can delete the model.
     *
     * @param  \App\User $user
     * @param  \App\Member $model
     * @return bool
     */
    public function delete(User $user, Member $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_DELETE);
    }
}
