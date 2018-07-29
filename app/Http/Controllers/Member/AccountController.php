<?php

namespace App\Http\Controllers\Member;

use App\Currency;
use App\Dto\OrderDetailDto;
use App\Http\Controllers\Controller;
use App\Member;
use App\Order;
use App\Package;
use App\Repository\Member\UserRepository;
use App\Service\Member\AccountService;
use App\Service\Member\AddressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    private $accountService;
    private $addressService;

    /**
     * AccountController constructor.
     *
     * @param AccountService $accountService
     * @param AddressService $addressService
     */
    public function __construct(AccountService $accountService, AddressService $addressService)
    {
        $this->accountService = $accountService;
        $this->addressService = $addressService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $member = Member::find(Auth::id());
        $title = __('account.profile');

        $address = $member->address()->first();

        return view('member.account.profile', compact('title', 'member', 'address'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function membership()
    {
        $member = Member::find(Auth::id());
        $membership = $member->membership()->first();
        $package = $membership->package()->first();
        $title = __('account.membership');

        return view('member.account.membership', compact('title', 'member', 'membership', 'package'));
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $member = Member::find(Auth::id());

        // validation
        $validator = $this->accountService->validate($member, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $member = $this->accountService->save($member, $request);

        return back()->with('status', 'Record saved successfully.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAddress(Request $request)
    {
        $member = Member::find(Auth::id());

        $this->addressService->updateOrCreateNewByModule(Member::class, $member->getId(), $request);

        return back()->with('status', 'Record saved successfully.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function upgradeMembership(Request $request)
    {
        $request->validate([
            'package_id' => 'required|integer|exists:' . Package::getTableName() . ',id',
            'type' => 'required|string|in:upgrade,renew'
        ]);

        $member = \Auth::user();
        /* @var Member $member */

        $package = Package::find($request->input('package_id'));

        switch ($package->getPackageType()) {
            case Package::MEMBER:
            case Package::PRO:

                // Create order
                /* @var Currency $currency */
                $currency = currency()->getCurrency();
                $order = new Order();
                $order->setOrderNo(md5(str_random(16) . microtime()));

                $order->setMemberId($member->getId());
                $order->setEmail($member->getEmail());
                $order->setUsername($member->getName());

                switch ($request->input('type')) {
                    case 'upgrade':
                        $order->setItemName('Upgrade package to ' . $package->packageTranslation->getName());
                        $order->setOrderType(Order::UPGRADE_MEMBERSHIP);
                        break;
                    case 'renew':
                        $order->setItemName('Renew package of ' . $package->packageTranslation->getName());
                        $order->setOrderType(Order::RENEW_MEMBERSHIP);
                        break;
                    default:
                }

                $order->setCurrencyId($currency['id']);
                $order->setCurrencyCode($currency['code']);
                $order->setCurrencyExchangeRate($currency['exchange_rate']);
                $order->setCurrencyFormat($currency['format']);
                $order->setCurrencySymbol($currency['symbol']);
                $order->setAmount($package->getPrice());

                $orderDetail = new OrderDetailDto();
                $orderDetail->setItemId($package->getId());
                $orderDetail->setItemModule(get_class($package));
                $orderDetail->setItemName('Register as package "' . $package->packageTranslation->getName() . '"');
                $orderDetail->setAmount($package->getPrice());
                $orderDetail->setQuantity(1);
                $order->setOrderDetails(serialize([$orderDetail->toArray()]));

                $order->setPaid(false);

                $order->save();

                return redirect(route('paypal.createSubmit', ['orderNo' => $order->getOrderNo()]));
                break;
            default:
        }

        return back();
    }
}
