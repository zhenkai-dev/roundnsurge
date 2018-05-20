<?php

namespace App\Service\Member;

use App\Enumeration\RouteTypeEnum;
use App\Repository\Member\MemberRepository;
use App\Service\Member\Util\LogUtil;
use App\Service\Member\Util\SaveAfterActionUtil;
use App\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MemberService
{
    private $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * Request validation
     *
     * @param Member    $member
     * @param Request $request
     * @return mixed
     */
    public function validate(Member $member, Request $request): \Illuminate\Validation\Validator
    {
        if (route_type() == RouteTypeEnum::STORE) {
            return Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:' . $member->getTable() . ',email',
                'mobile' => 'nullable|max:255',
                'dob' => 'nullable|date',
                'password' => 'required|min:8|max:20',
                'is_active' => 'required|boolean'
            ]);
        } else {
            return Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:members,email,' . $member->getId(),
                'mobile' => 'nullable|max:255',
                'dob' => 'nullable|date',
                'password' => 'nullable|min:8|max:20',
                'is_active' => 'required|boolean'
            ]);
        }
    }

    /**
     * Save entity
     *
     * @param Member    $member
     * @param Request $request
     * @return Member
     */
    public function save(Member $member, Request $request): Member
    {
        $member->setName($request->input('name'));
        $member->setMobile($request->input('mobile'));
        $member->setDob(new Carbon($request->input('dob')));
        $member->setEmail($request->input('email'));
        $member->setIsActive($request->input('is_active'));

        // reset password if presented
        if ($request->filled('password')) {
            $member->setPassword(Hash::make($request->input('password')));
        }

        // save
        $member->save();

        LogUtil::logChanges();

        return $member;
    }

    /**
     * @param Request $request
     * @param Member    $member
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveAfterAction(Request $request, Member $member)
    {
        return SaveAfterActionUtil::redirectAfterSaved(
            $request,
            route('admin.member.create'),
            route('admin.member.edit', $member->getId())
        );
    }

    /**
     * Delete entity
     *
     * @param Member    $member
     * @param Request $request
     * @throws \Exception
     */
    public function delete(Member $member, Request $request): void
    {
        $member->email = $member->email . '.' . time();
        $member->membername = $member->membername . '.' . time();

        $member->save();

        LogUtil::logChanges();

        $member->delete();
    }

    /**
     * Get entity listing
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getListing(Request $request): LengthAwarePaginator
    {
        return $this->memberRepository->findListing($request);
    }
}