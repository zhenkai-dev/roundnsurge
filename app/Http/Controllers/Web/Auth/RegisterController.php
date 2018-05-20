<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Member;
use App\Membership;
use App\Package;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo = route('member.home');
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . Member::getTableName(),
//            'dob' => 'required|date|date_format:"m/d/Y"',
//            'mobile' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            //'package' => 'nullable|integer|exists:' . Package::getTableName() . ',id'
            'package' => array(
                'nullable',
                'integer',
                Rule::exists(Package::getTableName(), 'id')->where(function (Builder $query) {
                    $query->where('is_active', '=', true);
                })
            )
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Member
     */
    protected function create(array $data)
    {
        $member = Member::create([
            'name' => $data['name'],
            'email' => $data['email'],
//            'dob' => $data['dob'],
//            'mobile' => $data['mobile'],
            'is_active' => true,
            'password' => bcrypt($data['password']),
        ]);

        // FREE Account
        $package = Package::where('package_type', '=', Package::BASIC)->first();

        if (!empty($data['package'])) {
            $packageCheck = Package::where('id', '=', $data['package'])
                ->where('is_active', true)
                ->first();

            switch ($packageCheck->getPackageType()) {
                case Package::MEMBER:
                case Package::PRO:
                    $this->redirectTo = route('member.membershipFee');
                    break;
            }
        }

        $membership = new Membership();
        $membership->setMemberId($member->getId());
        $membership->setPackageId($package->getId());
        $membership->setIsActive(true);
        $membership->save();

        return $member;
    }

    protected function guard()
    {
        return Auth::guard(config('auth.guards.web.name'));
    }

    public function showRegistrationForm()
    {
        return view('web.auth.register');
    }
}
