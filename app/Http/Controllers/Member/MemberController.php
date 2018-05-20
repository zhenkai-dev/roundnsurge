<?php

namespace App\Http\Controllers\Member;

use App\Enumeration\PolicyActionEnum;
use App\Http\Controllers\Controller;
use App\Member;
use App\Service\Member\MemberService;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    private $memberService;

    /**
     * Create a new controller instance.
     *
     * @param MemberService $memberService
     */
    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
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
        $this->authorize(PolicyActionEnum::INDEX, Member::class);

        $title = trans_choice('entity.member', 2);
        $members = $this->memberService->getListing($request);

        return view('member.member.list', compact('title', 'members'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize(PolicyActionEnum::CREATE, Member::class);

        $member = new Member();
        $title = __('form.add_new_record');
        return view('member.member.form', compact('title', 'member'));
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
        $this->authorize(PolicyActionEnum::CREATE, Member::class);

        $member = new Member();

        // validation
        $validator = $this->memberService->validate($member, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $member = $this->memberService->save($member, $request);

        return $this->memberService->saveAfterAction($request, $member)
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
     * @param Member $member
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Member $member)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $member);
        $address = $member->address()->first();

        $title = 'Edit ' . $member->getName();
        return view('member.member.form', compact('title', 'member', 'address'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Member  $member
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Member $member, Request $request)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $member);

        // validation
        $validator = $this->memberService->validate($member, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $member = $this->memberService->save($member, $request);

        return $this->memberService->saveAfterAction($request, $member)
            ->with('status', __('message.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Member  $member
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Member $member, Request $request)
    {
        $this->authorize(PolicyActionEnum::DELETE, $member);

        $this->memberService->delete($member, $request);

        return back()->with('status', __('message.record_deleted'));
    }
}
