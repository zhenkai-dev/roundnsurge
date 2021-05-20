<?php

namespace App\Http\Controllers\Admin;

use App\Enumeration\PolicyActionEnum;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Service\Admin\InvoiceService;
use Illuminate\Http\Request;
use DownloadAsPDF;

class InvoiceController extends Controller
{
    private $invoiceService;

    /**
     * Create a new controller instance.
     *
     * @param InvoiceService $invoiceService
     */
    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize(PolicyActionEnum::INDEX, Invoice::class);

        $title = trans_choice('entity.invoice', 2);
        $invoices = $this->invoiceService->getListing($request);

        return view('admin.invoice.list', compact('title', 'invoices'));
    }

    /**
     * Display the specified resource.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Invoice $invoice)
    {
        $this->authorize(PolicyActionEnum::VIEW, $invoice);

        $title = $invoice->formatInvoiceNo();
        $invoiceItems = $invoice->invoiceItems()->get();
        return view('admin.invoice.show', compact('title', 'invoice', 'invoiceItems'));
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

        $pdf = DownloadAsPDF::loadView('admin.invoice.detail', compact('invoice', 'invoiceItems'));

        return $pdf->download('invoice-'.$invoice->getInvoiceNo().'.pdf');
    }
}
