<?php

namespace App\Http\Controllers\Web\Auth;

use App\Currency;
use App\Dto\OrderDetailDto;
use App\Http\Controllers\Controller;
use App\Member;
use App\Membership;
use App\Order;
use App\Package;
use App\Service\Payment\OrderService;
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

    private $orderService;


    /**
     * Create a new controller instance.
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->redirectTo = route('member.home');
        $this->middleware('guest');

        $this->orderService = $orderService;

    }

    /**
     * Get a validator for an incoming registration request.
     *r
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:' . Member::getTableName(),
//            'dob' => 'required|date|date_format:"m/d/Y"',
            'mobile' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            //'package' => 'nullable|integer|exists:' . Package::getTableName() . ',id'
            'package' => array(
                'nullable',
                'integer',
                Rule::exists(Package::getTableName(), 'id')->where(function (Builder $query) {
                    $query->where('is_active', '=', true);
                })
            ),
            'g-recaptcha-response' => 'required|captcha'
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
            'mobile' => $data['mobile'],
            'is_active' => false, // set inactive first
            'password' => bcrypt($data['password']),
        ]);
        $redirect_referral = true;

        // FREE Account
        $package = Package::where('package_type', '=', Package::BASIC)->first();

        $membership = new Membership();
        $membership->setMemberId($member->getId());
        $membership->setPackageId($package->getId());
        $membership->setIsActive(true);
        $membership->save();

        if (!empty($data['package'])) {
            $packageCheck = Package::where('id', '=', $data['package'])
                ->where('is_active', true)
                ->first();

            switch ($packageCheck->getPackageType()) {
                case Package::MEMBER:
                case Package::PRO:
                    // set active if paid package
                    $member->is_active = true;
                    $member->save();
                    $redirect_referral = false;

                    // Create order
                    /* @var Currency $currency */
                    $currency = currency()->getCurrency();
                    $order = new Order();
                    $order->setOrderNo(md5(str_random(16) . microtime()));

                    $order->setMemberId($member->getId());
                    $order->setEmail($member->getEmail());
                    $order->setUsername($member->getName());

                    $order->setItemName('Register as ' . $packageCheck->packageTranslation->getName());
                    $order->setOrderType(Order::REGISTER_MEMBERSHIP);

                    $order->setCurrencyId($currency['id']);
                    $order->setCurrencyCode($currency['code']);
                    $order->setCurrencyExchangeRate($currency['exchange_rate']);
                    $order->setCurrencyFormat($currency['format']);
                    $order->setCurrencySymbol($currency['symbol']);
                    $order->setAmount($packageCheck->getPrice());

                    $orderDetail = new OrderDetailDto();
                    $orderDetail->setItemId($packageCheck->getId());
                    $orderDetail->setItemModule(get_class($packageCheck));
                    $orderDetail->setItemName('Register as package "' . $packageCheck->packageTranslation->getName() . '"');
                    $orderDetail->setAmount($packageCheck->getPrice());
                    $orderDetail->setQuantity(1);
                    $order->setOrderDetails(serialize([$orderDetail->toArray()]));

                    $order->setPaid(false);

                    $order->save();

                    $this->redirectTo = route('paypal.createSubmit', ['orderNo' => $order->getOrderNo()]);
                    break;
            }
        }

        if ($redirect_referral) {
            $this->redirectTo = route('web.register.referral');
        }

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

    public function referral()
    {
        if (auth()->user()->is_active) {
            // abort(404);
        }

        $page = \App\Page::where('id', 15)->where('is_active', true)->first();

        $pageTranslation = $page->pageTranslation(app('Language')->getId())->first();

        return view('web.auth.referral', compact('page', 'pageTranslation'));
    }
}
