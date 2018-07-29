<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 29/7/2018
 * Time: 1:14 AM
 */
?>

@extends('admin.layouts.app-show')

@section('heading')
    {!! $title !!}
@endsection

@section('show')

    @php /* @var \App\Invoice $invoice */ @endphp
    @php /* @var \Illuminate\Database\Eloquent\Collection $invoiceItem */ @endphp

    <div class="row">
        <div class="col-sm-6">
            <h1>{{ $title }}</h1>
        </div>
        <div class="col-sm-6 text-right">
            <h2>{{ $invoice->invoiceStatusToText() }}</h2>
            {{ __('invoice.paid_date') }}: {{ $invoice->getPaidDate()->setTimezone(session('timezone'))->toDayDateTimeString() }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <h3>Billing information</h3>
            <table class="table table-bordered">
                <tr>
                    <td>{{ __('invoice.billing_name') }}</td>
                    <td>{{ $invoice->getBillingName() }}</td>
                </tr>
                <tr>
                    <td>{{ __('invoice.billing_email') }}</td>
                    <td>{{ $invoice->getBillingEmail() }}</td>
                </tr>
                @if (!empty($invoice->getBillingContact()))
                    <tr>
                        <td>{{ __('invoice.billing_contact') }}</td>
                        <td>{{ $invoice->getBillingContact() }}</td>
                    </tr>
                @endif
                @if (!empty($invoice->getBillingAddress1()))
                    <tr>
                        <td>{{ __('invoice.billing_address') }}</td>
                        <td>
                            {{ $invoice->getBillingAddress1() }}<br />
                            {!! ($invoice->getBillingAddress2() ? $invoice->getBillingAddress2() . '<br />' : '') !!}
                            {{ $invoice->getBillingPostcode() }}, {{ $invoice->getBillingCity() }}<br />
                            {{ $invoice->getBillingState() }}<br />
                            {{ (\App\Country::find($invoice->getBillingCountryId()))->getName() }}<br />
                        </td>
                    </tr>
                @endif
            </table>
        </div>
    </div>

    @if (count($invoiceItems))
        <div>
            <h3>{{ trans_choice('entity.invoice_item', 2) }}</h3>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('invoice_item.item_name') }}</th>
                        <th class="text-right">{{ __('invoice_item.amount') }}</th>
                        <th class="text-right">{{ __('invoice_item.quantity') }}</th>
                        <th class="text-right">{{ __('invoice_item.total') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoiceItems as $invoiceItem)
                        @php /* @var \App\InvoiceItem $invoiceItem */ @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $invoiceItem->getItemName() }}</td>
                            <td class="text-right">{{ currency($invoiceItem->getAmount()) }}</td>
                            <td class="text-right">{{ $invoiceItem->getQuantity() }}</td>
                            <td class="text-right">{{ currency($invoiceItem->getAmount() * $invoiceItem->getQuantity()) }}</td>
                        </tr>
                    @endforeach
                    <tr class="font-weight-bold">
                        <td colspan="4" class="text-right">
                            {{ __('invoice_item.grand_total') }}
                        </td>
                        <td class="text-right">
                            {{ currency($invoice->getAmount()) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

    <a href="{{ URL::previous() }}" class="btn btn-light border" role="button">{{ __('common.back_to_previous') }}</a>

@endsection

