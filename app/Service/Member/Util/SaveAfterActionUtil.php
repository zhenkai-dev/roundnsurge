<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 28/1/2018
 * Time: 2:15 AM
 */

namespace App\Service\Member\Util;


use App\Enumeration\SaveAfterActionEnum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cookie;

class SaveAfterActionUtil
{
    public const SAVE_AFTER_ACTION_NAME = 'adminSaveAfterAction';

    public const EXPIRATION = '2 weeks';

    /**
     * @return string
     */
    public static function getSaveAfterAction(): string
    {
        return (string) Cookie::get(self::SAVE_AFTER_ACTION_NAME);
    }

    /**
     * @param string $saveAfterAction
     */
    public static function setSaveAfterAction(string $saveAfterAction): void
    {
        Cookie::queue(Cookie::make(self::SAVE_AFTER_ACTION_NAME, $saveAfterAction, strtotime(self::EXPIRATION, 0)));
    }

    /**
     * @param Request $request
     * @param string  $createNewUrl
     * @param string  $editCurrentUrl
     * @return RedirectResponse|Redirector
     */
    public static function redirectAfterSaved(Request $request, string $createNewUrl, string $editCurrentUrl)
    {
        $back = back();
        if ($request->filled('saveAfterAction')) {
            self::setSaveAfterAction($request->input('saveAfterAction'));

            /* @var RedirectResponse|Redirector $back */
            switch ($request->input('saveAfterAction')) {
                case SaveAfterActionEnum::BACK_TO_PREVIOUS:
                    if ($request->filled('previousUrl')) {
                        $back = redirect($request->input('previousUrl'));
                    }
                    break;
                case SaveAfterActionEnum::CONTINUE_EDIT:
                    $back = redirect($editCurrentUrl);
                    break;
                case SaveAfterActionEnum::INSERT_NEW_RECORD:
                    $back = redirect($createNewUrl);
                    break;
                default:
                    $back = back();
            }
        }
        return $back;
    }
}
