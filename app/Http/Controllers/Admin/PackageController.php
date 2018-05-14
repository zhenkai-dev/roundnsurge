<?php

namespace App\Http\Controllers\Admin;

use App\Enumeration\PolicyActionEnum;
use App\FriendlyUrl;
use App\Http\Controllers\Controller;
use App\Package;
use App\PackageTranslation;
use App\Service\Admin\PackageService;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    private $packageService;

    /**
     * Create a new controller instance.
     *
     * @param PackageService $packageService
     */
    public function __construct(PackageService $packageService)
    {
        $this->packageService = $packageService;
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
        $this->authorize(PolicyActionEnum::INDEX, Package::class);

        $title = trans_choice('entity.package', 2);
        $packages = $this->packageService->getListing($request);

        return view('admin.package.list', compact('title', 'packages'));
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
     * @param Package $package
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Package $package)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $package);

        /* @var PackageTranslation $packageTranslation */
        $packageTranslation = $package->packageTranslation(app('Language')->getId())->first();

        /* @var FriendlyUrl $friendlyUrl */
        $friendlyUrl = $package->friendlyUrl()->first();

        $title = 'Edit ' . $packageTranslation->getName();
        return view('admin.package.form', compact('title', 'package', 'packageTranslation', 'friendlyUrl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Package    $package
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Package $package, Request $request)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $package);

        // validation
        $validator = $this->packageService->validate($package, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $package = $this->packageService->save($package, $request);

        return $this->packageService->saveAfterAction($request, $package)
            ->with('status', __('message.record_updated'));
    }
}
