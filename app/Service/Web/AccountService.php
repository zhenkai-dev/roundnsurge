<?php

namespace App\Service\Web;

use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountService
{
    /**
     * Validation
     *
     * @param Member  $member
     * @param Request $request
     * @return mixed
     */
    public function validate(Member $member, Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:' . Member::getTableName() . ',email,' . $member->getId(),
            'dob' => 'required|date|date_format:"m/d/Y"',
            'mobile' => 'required|string|max:255',
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

        $member->setName($request->input('name'));
        $member->setEmail($request->input('email'));
        $member->setDob(new Carbon($request->input('dob')));
        $member->setMobile($request->input('mobile'));

        // save
        $member->save();

        return $member;
    }
}