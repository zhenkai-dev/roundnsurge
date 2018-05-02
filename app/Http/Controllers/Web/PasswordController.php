<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Member;
use App\Service\Web\PasswordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    private $passwordService;

    /**
     * Create a new controller instance.
     * PasswordController constructor.
     *
     * @param PasswordService $passwordService
     * @param UserRepository  $userRepository
     */
    public function __construct(PasswordService $passwordService)
    {
        $this->middleware('auth');
        $this->passwordService = $passwordService;
    }

    public function index()
    {
        $title = 'Change password';

        return view('web.account.password', compact('title'));
    }

    public function update(Request $request)
    {
        $member = Member::find(Auth::id());

        // validation
        $validator = $this->passwordService->validate($member, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $member = $this->passwordService->save($member, $request);

        return back()->with('status', 'Password updated successfully.');
    }
}
