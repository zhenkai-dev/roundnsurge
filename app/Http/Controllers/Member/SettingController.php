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
use App\Service\Admin\SettingService;
use App\Service\Admin\Util\PageSizeUtil;
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
