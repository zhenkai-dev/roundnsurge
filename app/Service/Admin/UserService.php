<?php

namespace App\Service\Admin;

use App\Enumeration\RouteTypeEnum;
use App\Repository\Admin\UserRepository;
use App\Service\Admin\Util\LogUtil;
use App\Service\Admin\Util\SaveAfterActionUtil;
use App\User;
use App\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Request validation
     *
     * @param User    $user
     * @param Request $request
     * @return mixed
     */
    public function validate(User $user, Request $request): \Illuminate\Validation\Validator
    {
        if (route_type() == RouteTypeEnum::STORE) {
            return Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:' . $user->getTable() . ',email',
                'username' => 'required|string|min:5|max:50|unique:' . $user->getTable() . ',username',
                'password' => 'required|string|min:8|max:20',
                'modules' => 'nullable|array|in:' . implode(',', array_keys(config('app.modules'))),
                'is_active' => 'required|boolean'
            ]);
        } else {
            return Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->getId(),
                'username' => 'required|string|min:5|max:50|unique:users,username,' . $user->getId(),
                'password' => 'nullable|string|min:8|max:20',
                'modules' => 'nullable|array|in:' . implode(',', array_keys(config('app.modules'))),
                'is_active' => 'required|boolean'
            ]);
        }
    }

    /**
     * Save entity
     *
     * @param User    $user
     * @param Request $request
     * @return User
     */
    public function save(User $user, Request $request): User
    {
        $user->setName($request->input('name'));
        $user->setUsername($request->input('username'));
        $user->setEmail($request->input('email'));
        $user->setIsActive($request->input('is_active'));

        // reset password if presented
        if ($request->filled('password')) {
            $user->setPassword(Hash::make($request->input('password')));
        }

        // save
        $user->save();

        $submittedModules = $request->input('modules');
        $modules = config('app.modules');

        $userPermissions = $user->userPermissions()->get();

        /* @var UserPermission[] $userPermissions */
        $hasPermissionKeyModules = [];
        if (count($userPermissions)) {
            foreach ($userPermissions as $userPermission) {
                $hasPermissionKeyModules[$userPermission->getModule()] = $userPermission;
            }
        }

        foreach ($modules as $module => $enabled) {
            if (!empty($hasPermissionKeyModules[$module])) {
                $userPermission = $hasPermissionKeyModules[$module];
            } else {
                $userPermission = new UserPermission();
                $userPermission->setUserId($user->getId());
                $userPermission->setModule($module);
            }
            if (in_array($module, $submittedModules)) {
                if ($enabled) {
                    $userPermission->setCanDelete(true);
                    $userPermission->setCanView(true);
                    $userPermission->setCanInsert(true);
                    $userPermission->setCanUpdate(true);
                    $userPermission->setIsActive(true);
                }
                unset($submittedModules[array_search($module, $submittedModules)]);
            } else {
                $userPermission->setCanDelete(false);
                $userPermission->setCanView(false);
                $userPermission->setCanInsert(false);
                $userPermission->setCanUpdate(false);
                $userPermission->setIsActive(false);
            }
            $userPermission->save();
        }

        LogUtil::logChanges();

        return $user;
    }

    /**
     * @param Request $request
     * @param User    $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveAfterAction(Request $request, User $user)
    {
        return SaveAfterActionUtil::redirectAfterSaved(
            $request,
            route('admin.user.create'),
            route('admin.user.edit', $user->getId())
        );
    }

    /**
     * Delete entity
     *
     * @param User    $user
     * @param Request $request
     * @throws \Exception
     */
    public function delete(User $user, Request $request): void
    {
        $user->email = $user->email . '.' . time();
        $user->username = $user->username . '.' . time();

        $user->save();

        $user->delete();

        LogUtil::logChanges();
    }

    /**
     * Get entity listing
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getListing(Request $request): LengthAwarePaginator
    {
        return $this->userRepository->findListing($request);
    }
}