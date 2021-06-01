<?php

use App\Member;

/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 28/7/2018
 * Time: 2:01 PM
 */

namespace App\Http\Controllers\Member;


use App\Enumeration\PolicyActionEnum;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Service\Member\InvoiceService;
use Illuminate\Http\Request;
use DownloadAsPDF;

class InvoiceController extends Controller
{
    private $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize(PolicyActionEnum::INDEX, Invoice::class);

        $title = trans_choice('entity.invoice', 2);

        $invoices = $this->invoiceService->getListing($request);

        return view('member.invoice.list', compact('title', 'invoices'));
    }

    /**
     * @param Invoice $invoice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Invoice $invoice)
    {
        $this->authorize(PolicyActionEnum::VIEW, $invoice);

        $title = $invoice->formatInvoiceNo();
        $invoiceItems = $invoice->invoiceItems()->get();
        return view('member.invoice.show', compact('title', 'invoice', 'invoiceItems'));
    }

    /**
     * Download the specified resource.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function downloadAsPDF(Invoice $invoice)
    {
        $invoiceItems = $invoice->invoiceItems()->get();

        $pdf = DownloadAsPDF::loadView('member.invoice.detail', compact('invoice', 'invoiceItems'));

        return $pdf->download('invoice-'.$invoice->formatInvoiceNo().'.pdf');
    }
}