<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 29/4/2018
 * Time: 4:30 PM
 */

namespace App\Http\Controllers\Admin;

use App\Enumeration\PolicyActionEnum;
use App\Http\Controllers\Controller;
use App\Member;
use App\Service\Admin\MembershipService;
use App\Service\Admin\MemberService;
use Illuminate\Http\Request;

class MemberMembershipController extends Controller
{
    private $membershipService;
    private $memberService;

    public function __construct(MembershipService $membershipService, MemberService $memberService)
    {
        $this->membershipService = $membershipService;
        $this->memberService = $memberService;
    }

    /**
     * @param Member  $member
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Member $member, Request $request)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $member);

        // validation
        $validator = $this->membershipService->validate($request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $this->membershipService->store($member, $request);

        return $this->memberService->saveAfterAction($request, $member)
            ->with('status', __('message.record_updated'));
    }
}
