<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repository\Admin\UserRepository;
use App\Service\Admin\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    private $accountService;
    private $userRepository;

    /**
     * Create a new controller instance.
     *
     * @param AccountService $accountService
     * @param UserRepository $userRepository
     */
    public function __construct(AccountService $accountService, UserRepository $userRepository)
    {
        $this->accountService = $accountService;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $user = Auth::user();
        $title = __('account.profile');

        return view('admin.account.profile', compact('title', 'user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // validation
        $validator = $this->accountService->validate($user, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = $this->accountService->save($user, $request);

        return back()->with('status', 'Record saved successfully.');
    }
}
