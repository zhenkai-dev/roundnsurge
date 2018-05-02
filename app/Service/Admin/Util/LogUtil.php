<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 28/1/2018
 * Time: 2:37 AM
 */

namespace App\Service\Admin\Util;


use App\UserLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogUtil
{
    public static function logChanges()
    {
        $queries = DB::getQueryLog();
        if (!empty($queries)) {
            $user = Auth::user();
            $logs = [];
            foreach ($queries as $key => $query) {
                if (starts_with($query['query'], 'update') ||
                    starts_with($query['query'], 'insert') ||
                    starts_with($query['query'], 'delete')) {
                    //\Illuminate\Support\Facades\Log::info($q['query'], $q['bindings'], $q['time']);
                    $userLog = new UserLog();
                    $userLog->setRouteName(\Route::currentRouteName());
                    $userLog->setQueryTime($query['time']);
                    $userLog->setBinding(serialize($query['bindings']));
                    $userLog->setStatement($query['query']);
                    array_push($logs, $userLog);
                }
            }
            if (!empty($logs)) {
                $user->userLogs()->saveMany($logs);
            }
        }
        return true;
    }
}