<?php

namespace App\Http\Controllers\Admin;

use App\Enumeration\PolicyActionEnum;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\Service\Admin\InvoiceService;
use Illuminate\Http\Request;
use DownloadAsPDF;
use Validator;

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

        return $pdf->download('invoice-'.$invoice->formatInvoiceNo().'.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Invoice $invoice)
    {
        $this->authorize(PolicyActionEnum::CREATE, $invoice);

        $title = __('invoice.add_new_invoice');
        return view('admin.invoice.form', compact('title', 'invoice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize(PolicyActionEnum::CREATE, Invoice::class);

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $this->invoiceService->save($request);

        return redirect()->route('admin.invoice.index');
    }
}
