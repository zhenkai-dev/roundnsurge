<?php

namespace App\Service\Admin;

use App\Repository\Admin\InvoiceRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Service\Payment\InvoiceService as InvService;
use App\Dto\OrderDetailDto;
use App\Order;
use App\Member;
use App\Membership;
use App\Invoice;
use App\InvoiceItem;
use App\Package;
use DB;
use Carbon\Carbon;

class InvoiceService
{
    private $invoiceRepository;

    private $friendlyUrlService;

    private $invService;

    public function __construct(InvoiceRepository $invoiceRepository, FriendlyUrlService $friendlyUrlService, InvService $invService)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->friendlyUrlService = $friendlyUrlService;
        $this->invService = $invService;
    }

    /**
     * Get entity listing
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getListing(Request $request): LengthAwarePaginator
    {
        return $this->invoiceRepository->findListing($request);
    }

    /**
     * Save entity
     *
     * @param Request $request
     * @return Invoice
     */
    public function save(Request $request)
    {
        $order = Order::find($request['order_id']);

        $paidAmount = (float)$order->getAmount();
        DB::transaction(function () use ($order, $paidAmount) {
            if (!$order->isPaid()) {
                $member = Member::find($order->getMemberId());

                //Create invoice
                $invoice = new Invoice();
                $invoice->setPrefix(config('payment.invoice_prefix'));
                $invoice->setAuthKey(md5(str_random(16)));
                $invoice->setBillingName($order->getUsername());
                $invoice->setBillingEmail($order->getEmail());

                if ($member) {
                    $invoice->setMemberId($order->getMemberId());
                    $invoice->setBillingContact($member->getMobile());
                    $address = $member->address()->first();

                    if ($address) {
                        /* @var Address $address */
                        $invoice->setBillingAddress1($address->getAddress1());
                        $invoice->setBillingAddress2($address->getAddress2());
                        $invoice->setBillingPostcode($address->getPostcode());
                        $invoice->setBillingCity($address->getCity());
                        $invoice->setBillingState($address->getState());
                        $invoice->setBillingCountryId($address->getCountryId());
                    }
                }

                $invoice->setCurrencyId($order->getCurrencyId());
                $invoice->setCurrencySymbol($order->getCurrencySymbol());
                $invoice->setCurrencyFormat($order->getCurrencyFormat());
                $invoice->setCurrencyExchangeRate($order->getCurrencyExchangeRate());
                $invoice->setCurrencyCode($order->getCurrencyCode());

                $this->invService->createInvoice($invoice);

                $lastInvoice = Invoice::orderBy('id', 'desc')->lockForUpdate()->first();

                $invoiceNo = config('payment.invoice_initial_number');
                /* @var \App\Invoice $lastInvoice */
                if ($lastInvoice != null) {
                    if($lastInvoice == "10000000") {
                        $invoiceNo = $invoiceNo;
                    } else {
                        $invoiceNo = $lastInvoice->getInvoiceNo() + 1;
                    }
                } 

                $invoice->setInvoiceNo($invoiceNo);
                $invoice->setAmount($order->getAmount());
                $invoice->setPaymentMethod(Invoice::PAY_METHOD_PAYPAL);
                $invoice->setPaid(true);
                $invoice->setPaidAmount($paidAmount);
                $invoice->setPaidDate($order->getCreatedAt());
                $invoice->setInvoiceStatus(Invoice::STATUS_PAID);

                $invoice->save();

                // Create invoice item
                if ($order->getOrderDetails()) {
                    $invoiceItem = new InvoiceItem();
                    $orderDetails = unserialize($order->getOrderDetails());

                    foreach ($orderDetails as $orderDetail) {
                        $orderDetailDto = OrderDetailDto::arrayToObject($orderDetail);
                        $invoiceItem->setItemName($orderDetailDto->getItemName());
                        $invoiceItem->setFkid($orderDetailDto->getItemId());
                        $invoiceItem->setModule($orderDetailDto->getItemModule());
                        $invoiceItem->setAmount($orderDetailDto->getAmount());
                        $invoiceItem->setQuantity($orderDetailDto->getQuantity());

                        if ($orderDetailDto->getItemModule() == Package::class) {
                            $package = Package::findOrFail($orderDetailDto->getItemId());
                            $duration = Package::getPackageDuration($package->package_type);

                            switch ($order->getOrderType()) {
                                case Order::REGISTER_MEMBERSHIP:
                                    $membership = new Membership();
                                    $membership->setMemberId($member->getId());
                                    $membership->setPackageId($orderDetailDto->getItemId());
                                    $membership->setExpiryDate(Carbon::now()->addMonth($duration));
                                    $membership->setIsActive(true);
                                    $membership->save();
                                    break;
                                case Order::UPGRADE_MEMBERSHIP:
                                case Order::RENEW_MEMBERSHIP:
                                    $currentMembership = $member->membership()->first();
                                    $membership = new Membership();
                                    $membership->setMemberId($member->getId());
                                    $membership->setPackageId($orderDetailDto->getItemId());

                                    if ($currentMembership->getExpiryDate() === null) {
                                        $membership->setExpiryDate(Carbon::now()->addMonth($duration));
                                    } else {
                                        if ($currentMembership->isExpired()) {
                                            $membership->setExpiryDate(Carbon::now()->addMonth($duration));
                                        } else {
                                            $membership->setExpiryDate($currentMembership->getExpiryDate()->addMonth($duration));
                                        }
                                    }

                                    $membership->setIsActive(true);
                                    $membership->save();
                                default:
                            }
                        }

                    }
                    $invoice->invoiceItems()->save($invoiceItem);
                }
                $order->setPaid(true);
                $order->save();
            }
        });
    }
}