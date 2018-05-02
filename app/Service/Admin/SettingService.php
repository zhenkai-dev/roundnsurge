<?php

namespace App\Service\Admin;

use App\Enumeration\RouteTypeEnum;
use App\Repository\Admin\SettingRepository;
use App\Service\Admin\Util\LogUtil;
use App\Service\Admin\Util\SaveAfterActionUtil;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SettingService
{
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * Request validation
     *
     * @param Setting    $setting
     * @param Request $request
     * @return mixed
     */
    public function validate(Setting $setting, Request $request): \Illuminate\Validation\Validator
    {
        if (route_type() == RouteTypeEnum::STORE) {
            return Validator::make($request->all(), [
                'site_name' => 'required|max:255',
                'enquiry_receiver' => 'required|email|max:255',
                'embed_script_top' => 'nullable',
                'embed_script_bottom' => 'nullable',
                'default_meta_title' => 'nullable',
                'default_meta_keywords' => 'nullable',
                'default_meta_description' => 'nullable'
            ]);
        } else {
            return Validator::make($request->all(), [
                'site_name' => 'required|max:255',
                'enquiry_receiver' => 'required|email|max:255',
                'embed_script_top' => 'nullable',
                'embed_script_bottom' => 'nullable',
                'default_meta_title' => 'nullable',
                'default_meta_keywords' => 'nullable',
                'default_meta_description' => 'nullable'
            ]);
        }
    }

    /**
     * Save entity
     *
     * @param Setting    $setting
     * @param Request $request
     * @return Setting
     */
    public function save(Setting $setting, Request $request): Setting
    {
        $setting->setSiteName($request->input('site_name'));
        $setting->setEnquiryReceiver($request->input('enquiry_receiver'));
        $setting->setEmbedScriptTop($request->input('embed_script_top'));
        $setting->setEmbedScriptBottom($request->input('embed_script_bottom'));
        $setting->setDefaultMetaTitle($request->input('default_meta_title'));
        $setting->setDefaultMetaKeywords($request->input('default_meta_keywords'));
        $setting->setDefaultMetaDescription($request->input('default_meta_description'));

        // save
        $setting->save();

        LogUtil::logChanges();

        return $setting;
    }
}