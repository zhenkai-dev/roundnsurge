<?php

namespace App\Service\Member;

use App\Member;
use App\Service\Member\Util\LogUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountService
{

    public function __construct()
    {

    }

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
            'email' => 'required|email|max:255|unique:' . Member::getTableName() . ',email,' . $member->getId()
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
        $member->setMobile($request->input('mobile'));
        $member->setDob(new Carbon($request->input('dob')));
        $member->setName($request->input('name'));
        $member->setEmail($request->input('email'));

        // save
        $member->save();

        LogUtil::logChanges();

        return $member;
    }
}