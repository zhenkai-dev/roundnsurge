<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 26/4/2018
 * Time: 9:30 PM
 */

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Member;
use App\Service\Web\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    private $accountService;

    /**
     * Create a new controller instance.
     *
     * @param AccountService $accountService
     */
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index()
    {
        $member = Auth::user();
        $title = 'Edit profile';

        return view('web.account.profile', compact('title', 'member'));
    }

    public function update(Request $request)
    {
        $member = Member::find(Auth::id());

        // validation
        $validator = $this->accountService->validate($member, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = $this->accountService->save($member, $request);

        return back()->with('status', 'Record saved successfully.');
    }
}
