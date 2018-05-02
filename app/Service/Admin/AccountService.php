<?php

namespace App\Service\Admin;

use App\Repository\Admin\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Validation
     *
     * @param User    $user
     * @param Request $request
     * @return mixed
     */
    public function validate(User $user, Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:' . User::getTableName() . ',email,' . $user->getId(),
            'username' => 'required|min:5|max:50|unique:' . User::getTableName() . ',username,' . $user->getId()
        ]);
    }

    /**
     * Save entity
     *
     * @param User    $user
     * @param Request $request
     * @return User
     */
    public function save(User $user, Request $request)
    {

        $user->setName($request->input('name'));
        $user->setUsername($request->input('username'));
        $user->setEmail($request->input('email'));

        // save
        $user->save();

        return $user;
    }
}