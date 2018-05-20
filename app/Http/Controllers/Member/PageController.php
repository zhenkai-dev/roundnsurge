<?php

namespace App\Http\Controllers\Member;

use App\Enumeration\PolicyActionEnum;
use App\FriendlyUrl;
use App\Http\Controllers\Controller;
use App\Page;
use App\PageTranslation;
use App\Service\Member\PageService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    private $pageService;

    /**
     * Create a new controller instance.
     *
     * @param PageService $pageService
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
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
        $this->authorize(PolicyActionEnum::INDEX, Page::class);

        $title = trans_choice('entity.page', 2);
        $pages = $this->pageService->getListing($request);

        return view('member.page.list', compact('title', 'pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize(PolicyActionEnum::CREATE, Page::class);

        $page = new Page();
        $title = __('form.add_new_record');
        return view('member.page.form', compact('title', 'page'));
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
        $this->authorize(PolicyActionEnum::CREATE, Page::class);

        $page = new Page();

        // validation
        $validator = $this->pageService->validate($page, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $page = $this->pageService->save($page, $request);

        return $this->pageService->saveAfterAction($request, $page)
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
     * @param Page $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Page $page)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $page);

        /* @var PageTranslation $pageTranslation */
        $pageTranslation = $page->pageTranslation(app('Language')->getId())->first();

        /* @var FriendlyUrl $friendlyUrl */
        $friendlyUrl = $page->friendlyUrl()->first();

        $title = 'Edit ' . $pageTranslation->getName();
        return view('member.page.form', compact('title', 'page', 'pageTranslation', 'friendlyUrl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Page    $page
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Page $page, Request $request)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $page);

        // validation
        $validator = $this->pageService->validate($page, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $page = $this->pageService->save($page, $request);

        return $this->pageService->saveAfterAction($request, $page)
            ->with('status', __('message.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Page    $page
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Page $page, Request $request)
    {
        $this->authorize(PolicyActionEnum::DELETE, $page);

        if ($page->isPersist() === false) {
            $this->pageService->delete($page, $request);

            return back()->with('status', __('message.record_deleted'));
        } else {
            return back()->withErrors(['msg' => __('message.record_delete_failed')]);
        }
    }
}
