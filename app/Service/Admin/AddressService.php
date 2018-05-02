<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 29/4/2018
 * Time: 6:27 PM
 */

namespace App\Service\Admin;

use App\Address;
use App\Country;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressService
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
            'address1' => 'required|string',
            'address2' => 'nullable|string',
            'city' => 'required|string',
            'postcode' => 'required|string',
            'state' => 'required|string',
            'country_id' => 'required|integer|exists:' . Country::getTableName() . ',id',
            'phone' => 'required|string',
        ]);
    }

    public function updateOrCreateNewByModule(string $module, int $id, Request $request): Address
    {
        $address = Address::where('fkid', '=', $id)
            ->where('module', '=', $module)
            ->first();

        if ($address === null) {
            $address = new Address();
        }

        $address->setFkid($id);
        $address->setModule($module);
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

        return $address;
    }
}
