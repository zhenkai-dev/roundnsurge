<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 22/7/2018
 * Time: 5:37 PM
 */

namespace App\Http\Controllers\Payment;


use App\Address;
use App\Dto\OrderDetailDto;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceItem;
use App\Member;
use App\Membership;
use App\Order;
use App\Package;
use App\Service\Payment\InvoiceService;
use App\Transaction;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
    private $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createFormAndSubmit(Request $request)
    {
        $order = Order::whereOrderNo($request->input('orderNo'))->first();
        if ($order != null) {
            return view('payment.paypal.form', compact('order'));
        }
        abort(404);
    }

    public function response(string $orderNo, Request $request)
    {
        $status = 'failed';
        if (!empty($orderNo)) {
            $order = Order::whereOrderNo($orderNo)->first();
            if ($order) {
                if ($order->isPaid()) {
                    $status = 'success';
                }
            }
        }

        return view('payment.paypal.response', compact('status'));
    }

    /**
     * @param Request $request
     * @throws \Exception
     * @throws \Throwable
     */
    public function ipn(Request $request)
    {

// CONFIG: Enable debug mode. This means we'll log requests into 'ipn.log' in the same directory.
// Especially useful if you encounter network errors or other intermittent problems with IPN (validation).
// Set this to 0 once you go live or don't require logging.
        define("DEBUG", 1);

// Set to 0 once you're ready to go live
        define("USE_SANDBOX", config('payment.sandbox_mode'));


        define("LOG_FILE", "./ipn.log");


// Read POST data
// reading posted data directly from $_POST causes serialization
// issues with array data in POST. Reading raw POST data from input stream instead.
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }
// read the post from PayPal system and add 'cmd'
        $req = 'cmd=_notify-validate';
        $get_magic_quotes_exists = false;
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }

// Post IPN data back to PayPal to validate the IPN data is genuine
// Without this step anyone can fake IPN data

        if (USE_SANDBOX == true) {
            $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
        } else {
            $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
        }

        $ch = curl_init($paypal_url);
        if ($ch == FALSE) {
            return FALSE;
        }

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

        if (DEBUG == true) {
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        }

// CONFIG: Optional proxy configuration
//curl_setopt($ch, CURLOPT_PROXY, $proxy);
//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);

// Set TCP timeout to 30 seconds
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name'));

// CONFIG: Please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path
// of the certificate as shown below. Ensure the file is readable by the webserver.
// This is mandatory for some environments.

//$cert = __DIR__ . "./cacert.pem";
//curl_setopt($ch, CURLOPT_CAINFO, $cert);

//        $_POST['mc_currency'] = 'MYR';
//        $_POST['mc_gross'] = '3888';
//        $_POST['invoice'] = '1990fd5e860e53a00ae52257117e6a6e';
//
//        $paidAmount = (float) $_POST['mc_gross'];
//
//        DB::transaction(function () use ($paidAmount) {
//            $order = Order::whereOrderNo($_POST['invoice'])->lockForUpdate()->first();
//            /* @var Order $order */
//
//            if ($_POST['mc_currency'] == $order->getCurrencyCode() && abs(($paidAmount - $order->getAmount()) / $order->getAmount()) < 0.00001) {
//                if (!$order->isPaid()) {
//                    $member = Member::find($order->getMemberId());
//
//                    // Create invoice
//                    $invoice = new Invoice();
//                    $invoice->setPrefix(config('payment.invoice_prefix'));
//                    $invoice->setAuthKey(md5(str_random(16)));
//                    $invoice->setBillingName($order->getUsername());
//                    $invoice->setBillingEmail($order->getEmail());
//
//                    if ($member) {
//                        $invoice->setMemberId($order->getMemberId());
//                        $invoice->setBillingContact($member->getMobile());
//                        $address = $member->address()->first();
//
//                        if ($address) {
//                            /* @var Address $address */
//                            $invoice->setBillingAddress1($address->getAddress1());
//                            $invoice->setBillingAddress2($address->getAddress2());
//                            $invoice->setBillingPostcode($address->getPostcode());
//                            $invoice->setBillingCity($address->getCity());
//                            $invoice->setBillingState($address->getState());
//                            $invoice->setBillingCountryId($address->getCountryId());
//                        }
//                    }
//
//                    $invoice->setCurrencyId($order->getCurrencyId());
//                    $invoice->setCurrencySymbol($order->getCurrencySymbol());
//                    $invoice->setCurrencyFormat($order->getCurrencyFormat());
//                    $invoice->setCurrencyExchangeRate($order->getCurrencyExchangeRate());
//                    $invoice->setCurrencyCode($order->getCurrencyCode());
//
//                    $this->invoiceService->createInvoice($invoice);
//
//                    $lastInvoice = Invoice::orderBy('id', 'desc')->lockForUpdate()->first();
//                    $invoiceNo = config('payment.invoice_initial_number');
//                    /* @var \App\Invoice $lastInvoice */
//                    if ($lastInvoice != null) {
//                        $invoiceNo = $lastInvoice->getInvoiceNo() + 1;
//                    }
//                    $invoice->setInvoiceNo($invoiceNo);
//                    $invoice->setAmount($order->getAmount());
//                    $invoice->setPaymentMethod(Invoice::PAY_METHOD_PAYPAL);
//                    $invoice->setPaid(true);
//                    $invoice->setPaidAmount($paidAmount);
//                    $invoice->setPaidDate(Carbon::now());
//                    $invoice->setInvoiceStatus(Invoice::STATUS_PAID);
//
//                    $invoice->save();
//
//                    // Create invoice item
//                    if ($order->getOrderDetails()) {
//                        $invoiceItem = new InvoiceItem();
//                        $orderDetails = unserialize($order->getOrderDetails());
//                        foreach ($orderDetails as $orderDetail) {
//                            $orderDetailDto = OrderDetailDto::arrayToObject($orderDetail);
//                            $invoiceItem->setItemName($orderDetailDto->getItemName());
//                            $invoiceItem->setFkid($orderDetailDto->getItemId());
//                            $invoiceItem->setModule($orderDetailDto->getItemModule());
//                            $invoiceItem->setAmount($orderDetailDto->getAmount());
//                            $invoiceItem->setQuantity($orderDetailDto->getQuantity());
//
//                            if ($orderDetailDto->getItemModule() == Package::class) {
//                                switch ($order->getOrderType()) {
//                                    case Order::REGISTER_MEMBERSHIP:
//                                        $membership = new Membership();
//                                        $membership->setMemberId($member->getId());
//                                        $membership->setPackageId($orderDetailDto->getItemId());
//                                        $membership->setExpiryDate(Carbon::now()->addMonth(config('app.package_expiry_duration')));
//                                        $membership->setIsActive(true);
//                                        $membership->save();
//                                        break;
//                                    case Order::UPGRADE_MEMBERSHIP:
//                                    case Order::RENEW_MEMBERSHIP:
//                                        $currentMembership = $member->membership()->first();
//                                        $membership = new Membership();
//                                        $membership->setMemberId($member->getId());
//                                        $membership->setPackageId($orderDetailDto->getItemId());
//
//                                        if ($currentMembership->getExpiryDate() === null) {
//                                            $membership->setExpiryDate(Carbon::now());
//                                        } else {
//                                            if ($currentMembership->isExpired()) {
//                                                $membership->setExpiryDate(Carbon::now()->addMonth(config('app.package_expiry_duration')));
//                                            } else {
//                                                $membership->setExpiryDate($currentMembership->getExpiryDate()->addMonth(config('app.package_expiry_duration')));
//                                            }
//                                        }
//
//                                        $membership->setIsActive(true);
//                                        $membership->save();
//                                    default:
//                                }
//                            }
//
//                        }
//                        $invoice->invoiceItems()->save($invoiceItem);
//                    }
//
//                    $order->setPaid(true);
//                    $order->save();
//                }
//            }
//        });
// Store transaction
        $res = curl_exec($ch);
        if (curl_errno($ch) != 0) // cURL error
        {
            if (DEBUG == true) {
                error_log(date('[Y-m-d H:i e] ') . "Can't connect to PayPal to validate IPN message: " . curl_error($ch) . PHP_EOL, 3, LOG_FILE);
            }
            curl_close($ch);
            exit;

        } else {
            // Log the entire HTTP response if debug is switched on.
            if (DEBUG == true) {
                error_log(date('[Y-m-d H:i e] ') . "HTTP request of validation request:" . curl_getinfo($ch, CURLINFO_HEADER_OUT) . " for IPN payload: $req" . PHP_EOL, 3, LOG_FILE);
                error_log(date('[Y-m-d H:i e] ') . "HTTP response of validation request: $res" . PHP_EOL, 3, LOG_FILE);

                // Split response headers and payload
                list($headers, $res) = explode("\r\n\r\n", $res, 2);
            }
            curl_close($ch);
        }

        // Store transaction
        $order = Order::whereOrderNo($_POST['invoice'])->first();
        $transaction = new Transaction();
        $transaction->setOrderId($order->getId());
        $transaction->setPaymentMethod(Invoice::PAY_METHOD_PAYPAL);
        $transaction->setResponse(http_build_query($_POST));
        $transaction->save();

        // Inspect IPN validation result and act accordingly

        if (strcmp($res, "VERIFIED") == 0) {
            // check whether the payment_status is Completed
            // check that txn_id has not been previously processed
            // check that receiver_email is your PayPal email
            // check that payment_amount/payment_currency are correct
            // process payment and mark item as paid.

            // assign posted variables to local variables
            //$item_name = $_POST['item_name'];
            //$item_number = $_POST['item_number'];
            //$payment_status = $_POST['payment_status'];
            //$payment_amount = $_POST['mc_gross'];
            //$payment_currency = $_POST['mc_currency'];
            //$txn_id = $_POST['txn_id'];
            //$receiver_email = $_POST['receiver_email'];
            //$payer_email = $_POST['payer_email'];

            if (DEBUG == true) {
                error_log(date('[Y-m-d H:i e] ') . "Verified IPN: $req " . PHP_EOL, 3, LOG_FILE);
            }

            $paidAmount = (float)$_POST['mc_gross'];

            if ($_POST['payment_status'] === 'Completed') {
                DB::transaction(function () use ($paidAmount) {
                    $order = Order::whereOrderNo($_POST['invoice'])->lockForUpdate()->first();
                    /* @var Order $order */

                    if ($_POST['mc_currency'] == $order->getCurrencyCode() && abs(($paidAmount - $order->getAmount()) / $order->getAmount()) < 0.00001) {
                        if (!$order->isPaid()) {
                            $member = Member::find($order->getMemberId());

                            // Create invoice
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

                            $this->invoiceService->createInvoice($invoice);

                            $lastInvoice = Invoice::orderBy('id', 'desc')->lockForUpdate()->first();
                            $invoiceNo = config('payment.invoice_initial_number');
                            /* @var \App\Invoice $lastInvoice */
                            if ($lastInvoice != null) {
                                if($lastInvoice == 10000000) {
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
                            $invoice->setPaidDate(Carbon::now());
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
                    }
                });
            }

        } else if (strcmp($res, "INVALID") == 0) {
            // log for manual investigation
            // Add business logic here which deals with invalid IPN messages
            if (DEBUG == true) {
                error_log(date('[Y-m-d H:i e] ') . "Invalid IPN: $req" . PHP_EOL, 3, LOG_FILE);
            }
        }
    }
}