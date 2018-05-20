<?php
/**
 * Created by PhpStorm.
 * Setting: Kit Loong
 * Date: 28/1/2018
 * Time: 1:54 AM
 */

namespace App\Http\Controllers\Member;

use App\Enumeration\PolicyActionEnum;
use App\Http\Controllers\Controller;
use App\Service\Member\SettingService;
use App\Service\Member\Util\PageSizeUtil;
use App\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    private $settingService;

    /**
     * Create a new controller instance.
     *
     * @param SettingService $settingService
     */
    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit()
    {
        $setting = Setting::find(config('app.setting_id'));

        $this->authorize(PolicyActionEnum::UPDATE, $setting);

        $title = 'Edit ' . trans_choice('entity.setting', 1);
        return view('member.setting.form', compact('title', 'setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request)
    {
        $setting = Setting::find(config('app.setting_id'));

        $this->authorize(PolicyActionEnum::UPDATE, $setting);

        // validation
        $validator = $this->settingService->validate($setting, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $setting = $this->settingService->save($setting, $request);

        return back()->with('status', __('message.record_updated'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function setPageSize(Request $request): JsonResponse
    {
        //validate page size value
        $this->validate($request, [
            'pageSize' => 'required|integer|in:' . implode(',', PageSizeUtil::getPageSizeList())
        ]);

        return response()->json([
            true
        ])->cookie(PageSizeUtil::PAGE_SIZE_NAME, $request->post('pageSize'), strtotime(PageSizeUtil::EXPIRATION, 0));
    }

    public function setClientTimezone(Request $request)
    {
        if (in_array($request->input('timezone'), \DateTimeZone::listIdentifiers())) {
            $request->session()->put('timezone', $request->input('timezone'));
        } else {
            $request->session()->put('timezone', date_default_timezone_get());
        }
        return [true];
    }
}
