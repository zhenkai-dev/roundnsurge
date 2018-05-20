<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 28/1/2018
 * Time: 2:37 AM
 */

namespace App\Service\Member\Util;


use App\Member;
use App\MemberLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogUtil
{
    public static function logChanges()
    {
        $queries = DB::getQueryLog();
        if (!empty($queries)) {
            $user = Member::find(Auth::id());
            $logs = [];
            foreach ($queries as $key => $query) {
                if (starts_with($query['query'], 'update') ||
                    starts_with($query['query'], 'insert') ||
                    starts_with($query['query'], 'delete')) {
                    //\Illuminate\Support\Facades\Log::info($q['query'], $q['bindings'], $q['time']);
                    $userLog = new MemberLog();
                    $userLog->setRouteName(\Route::currentRouteName());
                    $userLog->setQueryTime($query['time']);
                    $userLog->setBinding(serialize($query['bindings']));
                    $userLog->setStatement($query['query']);
                    array_push($logs, $userLog);
                }
            }
            if (!empty($logs)) {
                $user->memberLogs()->saveMany($logs);
            }
        }
        return true;
    }
}