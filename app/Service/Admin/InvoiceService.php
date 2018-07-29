<?php

namespace App\Service\Admin;

use App\Repository\Admin\InvoiceRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class InvoiceService
{
    private $invoiceRepository;

    private $friendlyUrlService;

    public function __construct(InvoiceRepository $invoiceRepository, FriendlyUrlService $friendlyUrlService)
    {
        $this->invoiceRepository = $invoiceRepository;
        $this->friendlyUrlService = $friendlyUrlService;
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
}