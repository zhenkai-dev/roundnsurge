<?php

namespace App\Policies\Member;

use App\Enumeration\RolePermissionEnum;
use App\Member;
use App\Member;
use Illuminate\Auth\Access\HandlesAuthorization;

class MemberPolicy
{
    use HandlesAuthorization;

    public $module = 'member';

    /**
     * Determine whether is admin
     *
     * @param Member $user
     * @return bool
     */
    public function before(Member $user): ?bool
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
     * @param  \App\Member $user
     * @return bool
     */
    public function index(Member $user): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_VIEW);
    }

    /**
     * Determine whether the member can view the model.
     *
     * @param  \App\Member $user
     * @param  \App\Member $model
     * @return bool
     */
    public function view(Member $user, Member $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_VIEW);
    }

    /**
     * Determine whether the member can create models.
     *
     * @param  \App\Member $user
     * @return bool
     */
    public function create(Member $user): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_INSERT);
    }

    /**
     * Determine whether the member can update the model.
     *
     * @param  \App\Member $user
     * @param  \App\Member $model
     * @return bool
     */
    public function update(Member $user, Member $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_UPDATE);
    }

    /**
     * Determine whether the member can delete the model.
     *
     * @param  \App\Member $user
     * @param  \App\Member $model
     * @return bool
     */
    public function delete(Member $user, Member $model): bool
    {
        return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_DELETE);
    }
}
