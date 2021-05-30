<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 27/7/2018
 * Time: 7:37 AM
 */

namespace App\Service\Payment;


use App\Invoice;
use DB;

class InvoiceService
{
    /**
     * @param Invoice $invoice
     * @throws \Exception
     * @throws \Throwable
     */
    public function createInvoice(Invoice $invoice) {
        DB::transaction(function () use ($invoice) {
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
        });
    }
}