<?php

namespace App\Service\Member;

use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PasswordService
{

    public function __construct()
    {
    }

    /**
     * @param Member  $member
     * @param Request $request
     * @return mixed
     */
    public function validate(Member $member, Request $request)
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
     * @param Member  $member
     * @param Request $request
     * @return Member
     */
    public function save(Member $member, Request $request)
    {
        $member->setPassword(Hash::make($request->input('password')));

        // save
        $member->save();

        return $member;
    }
}