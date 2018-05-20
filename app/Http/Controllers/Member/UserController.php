<?php

namespace App\Http\Controllers\Member;

use App\Enumeration\PolicyActionEnum;
use App\Http\Controllers\Controller;
use App\Service\Member\UserService;
use App\User;
use App\UserPermission;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    /**
     * Create a new controller instance.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize(PolicyActionEnum::INDEX, User::class);

        $title = trans_choice('entity.user', 2);
        $users = $this->userService->getListing($request);

        return view('member.user.list', compact('title', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize(PolicyActionEnum::CREATE, User::class);

        $user = new User();
        $title = __('form.add_new_record');
        return view('member.user.form', compact('title', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize(PolicyActionEnum::CREATE, User::class);

        $user = new User();

        // validation
        $validator = $this->userService->validate($user, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = $this->userService->save($user, $request);

        return $this->userService->saveAfterAction($request, $user)
            ->with('status', __('message.record_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $user);

        /* @var UserPermission[] $userPermissions */
        $userPermissions = $user->userPermissions()->get();
        $userHasModules = [];
        if (count($userPermissions)) {
            foreach ($userPermissions as $userPermission) {
                if ($userPermission->isActive()) {
                    $userHasModules[] = $userPermission->getModule();
                }
            }
        }

        $title = 'Edit ' . $user->getName();
        return view('member.user.form', compact('title', 'user', 'userHasModules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User    $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(User $user, Request $request)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $user);

        // validation
        $validator = $this->userService->validate($user, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = $this->userService->save($user, $request);

        return $this->userService->saveAfterAction($request, $user)
            ->with('status', __('message.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User    $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user, Request $request)
    {
        $this->authorize(PolicyActionEnum::DELETE, $user);

        if ($user->isPersist() === false) {
            $this->userService->delete($user, $request);

            return back()->with('status', __('message.record_deleted'));
        } else {
            return back()->withErrors(['msg' => __('message.record_delete_failed')]);
        }
    }
}
