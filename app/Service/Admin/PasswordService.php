<?php

namespace App\Service\Admin;

use App\Repository\Admin\UserRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param User    $user
     * @param Request $request
     * @return mixed
     */
    public function validate(User $user, Request $request)
    {
        return Validator::make($request->all(), [
            'password_old' => 'required|min:8|max:20|passcheck:password_old',
            'password' => 'required||min:8|max:20|different:password_old',
            'password_confirm' => 'required|same:password',
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
        $user->setPassword(Hash::make($request->input('password')));

        // save
        $user->save();

        return $user;
    }
}