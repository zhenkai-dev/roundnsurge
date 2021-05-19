<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 29/7/2018
 * Time: 1:14 AM
 */
?>

@extends('member.layouts.app-show')

@section('heading')
    {!! $title !!}
@endsection

@section('show')

    @php /* @var \App\Invoice $invoice */ @endphp
    @php /* @var \Illuminate\Database\Eloquent\Collection $invoiceItem */ @endphp

    <div class="row">
        <div class="col-sm-6">
            <img src="{{ asset('images/logo.png')}}" alt="logo" title="logo" />
        </div>
        <div class="col-sm-6 text-right">
            <h1>{{ __('invoice.invoice') }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <br>
            <table cellpadding="0" cellspacing="0" width="100%" border="0">
                <tbody>
                    <tr>
                        <td align="left">  
                            <div>
                                <p><span><strong>{{ __('invoice.business_name') }}</strong></span>
                                <br>{{ __('invoice.business_address1') }},
                                <br>{{ __('invoice.business_address2') }},
                                <br>{{ __('invoice.business_postcode') }} {{ __('invoice.business_city') }},
                                {{ __('invoice.business_state') }}.<br>
                                {{ __('invoice.phone') }}: {{ __('invoice.business_contactno') }}</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
                
            <table cellpadding="0" cellspacing="0" width="100%" border="0">
                <tbody>
                    <tr>
                        <td align="left">  
                            <div>
                                <p><span><strong>{{ __('invoice_item.bill_to') }}</strong></span>
                                <br>
                                {{ $invoice->getBillingName() }}<br>
                                @if(!is_null($invoice->getBillingAddress1()))
                                {{ $invoice->getBillingAddress1() }}<br>
                                @endif
                                @if(!is_null($invoice->getBillingAddress2()))
                                {{ $invoice->getBillingAddress2() }}<br>
                                @endif
                                @if(!is_null($invoice->getBillingPostcode()) && !is_null($invoice->getBillingCity()))
                                {{ $invoice->getBillingPostcode() }}, {{ $invoice->getBillingCity() }}.<br>
                                @endif
                                {{ $invoice->getBillingContact() }}<br>
                                {{ $invoice->getBillingEmail() }}</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-6" id="main-subtable">
            <table id="subtable">
                <tr>
                    <th>{{ __('invoice.invoice') }}#</th>
                    <th>{{ __('invoice.date') }}</th>
                </tr>
                <tr>
                    <td>{{ $invoice->getInvoiceNo() }}</td>
                    <td>{{ date('d-m-Y', strtotime($invoice->getPaidDate())) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <hr id="line-break" />

    @if (count($invoiceItems))
        <div style="overflow-x:auto;">
            <table class="table" id="no-border-table">
                <thead>
                    <tr>
                        <th>{{ __('invoice_item.item') }}</th>
                        <th>{{ __('invoice_item.description') }}</th>
                        <th class="text-right">{{ __('invoice_item.quantity') }}</th>
                        <th class="text-right">{{ __('invoice_item.price') }}</th>
                        <th class="text-right">{{ __('invoice_item.amount') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoiceItems as $invoiceItem)
                        @php /* @var \App\InvoiceItem $invoiceItem */ @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $invoiceItem->getItemName() }}</td>
                            <td class="text-right">{{ $invoiceItem->getQuantity() }}</td>
                            <td class="text-right">{{ currency($invoiceItem->getAmount()) }}</td>
                            <td class="text-right">{{ currency($invoiceItem->getAmount() * $invoiceItem->getQuantity()) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- START Unlayer html template-->
    <div class="u-row-container" style="padding: 0px;background-color: transparent;overflow-x:auto;">
        <div class="u-row" style="overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: #ffffff;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
        <div class="u-col u-col-66p83" style="max-width: 320px;min-width: 401px;display: table-cell;vertical-align: top;">
        <div style="background-color: #c2e0f4;width: 100% !important;">
        <div style="padding: 55px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
        
        <table style="font-family:'Open Sans',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
        <tbody>
            <tr>
            <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Open Sans',sans-serif;" align="left">
                
        <div class="v-text-align" style="color: #5c5757; line-height: 140%; text-align: left; word-wrap: break-word;">
            <p style="font-size: 14px; line-height: 140%;"><strong><span style="font-size: 14px; line-height: 19.6px;">{{ __('invoice_item.notes') }}:</span></strong></p>
        <p style="font-size: 14px; line-height: 140%;"><span style="font-size: 12px; line-height: 16.8px;">- {{ __('invoice_item.notes1') }}</span></p>
        <p style="font-size: 14px; line-height: 140%;"><span style="font-size: 12px; line-height: 16.8px;">- {{ __('invoice_item.notes2') }}</span></p>
        <p style="font-size: 14px; line-height: 140%;"><span style="font-size: 12px; line-height: 16.8px;">- {{ __('invoice_item.notes3') }}</span></p>
        </div>
        
            </td>
            </tr>
        </tbody>
        </table>
        
        </div>
        </div>
        </div>
        <div class="u-col u-col-33p17" style="max-width: 320px;min-width: 199px;display: table-cell;vertical-align: top;">
        <div style="background-color: #054169;width: 100% !important;">
        <div style="padding: 35px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
        
        <table style="font-family:'Open Sans',sans-serif;" role="presentation" cellpadding="0" cellspacing="0" width="100%" border="0">
        <tbody>
            <tr>
            <td style="overflow-wrap:break-word;word-break:break-word;padding:92px 0px 20px;font-family:'Open Sans',sans-serif;" align="left">
                
        <div class="v-text-align" style="color: #ffffff; line-height: 140%; text-align: left; word-wrap: break-word;">
            <p style="font-size: 14px; line-height: 140%; text-align: right;"><strong><span style="font-size: 14px; line-height: 19.6px;">{{ __('invoice_item.total') }}</span></strong></p>
        <p style="font-size: 14px; line-height: 140%; text-align: right;"><span style="font-size: 26px; line-height: 36.4px;"><strong><span style="line-height: 36.4px; font-size: 26px;">{{ __('invoice_item.currency') }}{{ number_format($invoice->getPaidAmount(), 2) }} </span></strong></span></p>
        </div>
        
            </td>
            </tr>
        </tbody>
        </table>
        
        </div>
        </div>
        </div>
        </div>
        </div>
    </div>
    <!-- END Unlayer html template-->
    <br>

    <div class="row">
        <div class="col-sm-12 text-center">
            <h1>{{ __('common.thank_you') }}.</h1>
        </div>
    </div>
    <br>

    <a href="{{ URL::previous() }}" class="btn btn-light border" role="button">{{ __('common.back_to_previous') }}</a>

@endsection

