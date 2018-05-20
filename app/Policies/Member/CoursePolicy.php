<?php

namespace App\Policies\Member;

use App\Enumeration\RolePermissionEnum;
use App\Course;
use App\Member;
use App\Package;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    public $module = 'course';

    /**
     * Determine whether is admin
     *
     * @param Member $user
     * @return bool
     */
    public function before(Member $user): ?bool
    {
        if (config('app.modules.course') != true) {
            return false;
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Member $user
     * @param  \App\Member $model
     * @return bool
     */
    public function view(Member $user, Course $model): bool
    {
        $check = $model->packages()
            ->where(Package::getTableName() . '.id', '=', $user->membership->getPackageId())
            ->get();
        return count($check) > 0 && $model->isActive();

        // return $user->isUserPermitted($this->module, RolePermissionEnum::CAN_VIEW);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Member $user
     * @return bool
     */
    public function create(Member $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Member $user
     * @param  \App\Member $model
     * @return bool
     */
    public function update(Member $user, Course $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Member $user
     * @param  \App\Member $model
     * @return bool
     */
    public function delete(Member $user, Course $model): bool
    {
        return false;
    }
}
