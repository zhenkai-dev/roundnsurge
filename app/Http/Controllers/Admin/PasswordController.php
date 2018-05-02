<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repository\Admin\UserRepository;
use App\Service\Admin\PasswordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    private $passwordService;
    private $userRepository;

    /**
     * Create a new controller instance.
     * PasswordController constructor.
     *
     * @param PasswordService $passwordService
     * @param UserRepository  $userRepository
     */
    public function __construct(PasswordService $passwordService, UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->passwordService = $passwordService;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $title = 'Change password';

        return view('admin.account.password', compact('title'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // validation
        $validator = $this->passwordService->validate($user, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = $this->passwordService->save($user, $request);

        return back()->with('status', 'Password updated successfully.');
    }
}
