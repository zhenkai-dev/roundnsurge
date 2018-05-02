<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 29/4/2018
 * Time: 1:21 AM
 */

namespace App\Http\Controllers\Web\Account;

use App\Country;
use App\Http\Controllers\Controller;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $member = Member::find(Auth::id());
        $address = $member->address()->first();
        $title = 'Address';

        return view('web.account.address', compact('title', 'address'));
    }

    public function update(Request $request)
    {
        // Validation
        $validator = $this->validate($request, [
            'address1' => 'required|string',
            'address2' => 'nullable|string',
            'city' => 'required|string',
            'postcode' => 'required|string',
            'state' => 'required|string',
            'country_id' => 'required|integer|exists:' . Country::getTableName() . ',id',
            'phone' => 'required|string',
        ]);

        $member = Member::find(Auth::id());

        /* @var \App\Address $address */
        $address = $member->address()->firstOrNew([]);
        $address->setFkid($member->getId());
        $address->setModule(Member::class);
        $address->setAddress1($request->input('address1'));
        $address->setAddress2($request->input('address2'));
        $address->setPostcode($request->input('postcode'));
        $address->setCity($request->input('city'));
        $address->setState($request->input('state'));
        $address->setCountryId($request->input('country_id'));
        $address->setPhone($request->input('phone'));
        $address->setIsActive(true);
        $address->setUseDefault(true);
        $address->save();

        return back()->with('status', 'Record saved successfully.');
    }
}