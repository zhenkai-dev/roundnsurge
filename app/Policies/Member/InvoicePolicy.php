<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 28/7/2018
 * Time: 1:55 PM
 */

namespace App\Policies\Member;


use App\Invoice;
use App\Member;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    public $module = 'invoice';

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
     * @param Invoice      $model
     * @return bool
     */
    public function view(Member $user, Invoice $model): bool
    {
        return true;
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
     * @param Invoice      $model
     * @return bool
     */
    public function update(Member $user, Invoice $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Member $user
     * @param Invoice      $model
     * @return bool
     */
    public function delete(Member $user, Invoice $model): bool
    {
        return false;
    }
}