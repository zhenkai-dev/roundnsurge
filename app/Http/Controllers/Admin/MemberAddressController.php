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
use App\Service\Admin\AddressService;
use App\Service\Admin\MemberService;
use Illuminate\Http\Request;

class MemberAddressController extends Controller
{
    private $addressService;
    private $memberService;

    public function __construct(AddressService $addressService, MemberService $memberService)
    {
        $this->addressService = $addressService;
        $this->memberService = $memberService;
    }

    /**
     * @param Member  $member
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Member $member, Request $request)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $member);

        $this->addressService->updateOrCreateNewByModule(Member::class, $member->getId(), $request);

        return $this->memberService->saveAfterAction($request, $member)
            ->with('status', __('message.record_updated'));
    }
}
