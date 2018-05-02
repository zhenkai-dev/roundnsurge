<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\BannerTranslation;
use App\Enumeration\PolicyActionEnum;
use App\Http\Controllers\Controller;
use App\Service\Admin\BannerService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    private $bannerService;

    /**
     * Create a new controller instance.
     *
     * @param BannerService $bannerService
     */
    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
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
        $this->authorize(PolicyActionEnum::INDEX, Banner::class);

        $title = trans_choice('entity.banner', 2);
        $banners = $this->bannerService->getListing($request)->get();

        return view('admin.banner.list', compact('title', 'banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize(PolicyActionEnum::CREATE, Banner::class);

        $banner = new Banner();
        $title = __('form.add_new_record');
        return view('admin.banner.form', compact('title', 'banner'));
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
        $this->authorize(PolicyActionEnum::CREATE, Banner::class);

        $banner = new Banner();

        // validation
        $validator = $this->bannerService->validate($banner, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $banner = $this->bannerService->save($banner, $request);

        return $this->bannerService->saveAfterAction($request, $banner)
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
     * @param Banner $banner
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Banner $banner)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $banner);

        /* @var BannerTranslation $bannerTranslation */
        $bannerTranslation = $banner->bannerTranslation(app('Language')->getId())->first();

        $title = 'Edit ' . $bannerTranslation->getName();
        return view('admin.banner.form', compact('title', 'banner', 'bannerTranslation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Banner  $banner
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Banner $banner, Request $request)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $banner);

        // validation
        $validator = $this->bannerService->validate($banner, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $banner = $this->bannerService->save($banner, $request);

        return $this->bannerService->saveAfterAction($request, $banner)
            ->with('status', __('message.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Banner  $banner
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Banner $banner, Request $request)
    {
        $this->authorize(PolicyActionEnum::DELETE, $banner);

        $this->bannerService->delete($banner, $request);

        return back()->with('status', __('message.record_deleted'));
    }

    public function sortable(Request $request)
    {
        $ordering = $request->input('ordering');
        if (!empty($ordering)) {
            $this->bannerService->sortable($ordering);
        }
        return $request->input('ordering');
    }
}
