<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 29/4/2018
 * Time: 6:27 PM
 */

namespace App\Service\Admin;

use App\Membership;
use App\Member;
use App\Package;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MembershipService
{
    /**
     * Request validation
     *
     * @param Member  $member
     * @param Request $request
     * @return mixed
     */
    public function validate(Request $request): \Illuminate\Validation\Validator
    {
        return Validator::make($request->all(), [
            'package_id' => 'required|string',
            'expiry_date' => 'nullable|date',
        ]);
    }

    public function store(Member $member, Request $request)
    {
        $membership = new Membership();
        $membership->setPackageId($request->input('package_id'));
        if ($request->input('package_id') != Package::BASIC) {
            if ($request->input('expiry_date') === null) {
                $membership->setExpiryDate(Carbon::now()->addMonth(config('app.package_expiry_duration')));
            } else {
                $membership->setExpiryDate(new Carbon($request->input('expiry_date')));
            }
        }
        $membership->setIsActive(true);
        
        $member->memberships()->save($membership);

        return $membership;
    }
}
