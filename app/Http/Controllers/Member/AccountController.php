<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Member;
use App\Repository\Member\UserRepository;
use App\Service\Member\AccountService;
use App\Service\Member\AddressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    private $accountService;
    private $userRepository;
    private $addressService;

    /**
     * AccountController constructor.
     *
     * @param AccountService $accountService
     * @param UserRepository $userRepository
     * @param AddressService $addressService
     */
    public function __construct(AccountService $accountService, UserRepository $userRepository, AddressService $addressService)
    {
        $this->accountService = $accountService;
        $this->userRepository = $userRepository;
        $this->addressService = $addressService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $member = Member::find(Auth::id());
        $title = __('account.profile');

        $address = $member->address()->first();

        return view('member.account.profile', compact('title', 'member', 'address'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function membership()
    {
        $member = Member::find(Auth::id());
        $membership = $member->membership()->first();
        $package = $membership->package()->first();
        $title = __('account.membership');

        return view('member.account.membership', compact('title', 'member', 'membership', 'package'));
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $member = Member::find(Auth::id());

        // validation
        $validator = $this->accountService->validate($member, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $member = $this->accountService->save($member, $request);

        return back()->with('status', 'Record saved successfully.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAddress(Request $request)
    {
        $member = Member::find(Auth::id());

        $this->addressService->updateOrCreateNewByModule(Member::class, $member->getId(), $request);

        return back()->with('status', 'Record saved successfully.');
    }
}
