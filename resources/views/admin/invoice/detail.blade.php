<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('invoice.invoice') }} #{{ $invoice->formatInvoiceNo() }}</title>
    <link href="{{ public_path('member/css/style.css') }}" rel="stylesheet" type="text/css" />
    <style>        
        #subtable th {
            padding: 0 5px !important;
        }

        #subtable td {
            padding: 18px 5px !important;
            font-size: 12px;
        }

        .font-verdana {
            font-family: Verdana;
        }

        .font-arial {
            font-family: Arial;
        }

        .font-cambria {
            font-family: 'Cambria';
        }

        .font-calibri {
            font-family: 'Calibri';
        }
    </style>
</head>
<body style="background:none;">
    <div class="row">
        <div class="col-sm-6">
            <img src="{{ public_path('images/logo.png')}}" alt="logo" title="logo" />
        </div>
        <div class="col-sm-6" style="position:absolute;right:-180px;">
            <h1 class="font-arial" style="font-weight:500;font-size:46px;">{{ __('invoice.invoice') }}</h1>
        </div>
    </div>
    
    <div class="row" style="margin-top: -110px !important;">
        <div class="col-md-6">
            <br>
            <table cellpadding="0" cellspacing="0" width="100%" border="0">
                <tbody>
                    <tr>
                        <td align="left">  
                            <div class="font-arial">
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
                
            <table class="mt-4" cellpadding="0" cellspacing="0" width="100%" border="0">
                <tbody>
                    <tr>
                        <td align="left">  
                            <div>
                                <p class="font-cambria"><span class="font-arial"><strong>{{ __('invoice_item.bill_to') }}</strong></span>
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
    
        <div class="col-md-6" id="main-subtable" style="margin-left:510px;">
            <table width="100%" id="subtable" style="margin-top:31px;">
                <tr class="font-arial">
                    <th width="50%" style="font-weight: normal;">{{ __('invoice.invoice') }}#</th>
                    <th width="50%" style="font-weight: normal;">{{ __('invoice.date') }}</th>
                </tr>
                <tr class="font-calibri">
                    <td width="50%">{{ $invoice->formatInvoiceNo() }}</td>
                    <td width="50%">{{ date('d-m-Y', strtotime($invoice->getPaidDate())) }}</td>
                </tr>
            </table>
        </div>
    </div>
    
    <hr id="line-break" />
    
    @if (count($invoiceItems))
        <div style="overflow-x:auto;">
            <table class="table" id="no-border-table">
                <thead>
                    <tr class="font-arial">
                        <th>{{ __('invoice_item.item') }}</th>
                        <th class="text-left">{{ __('invoice_item.description') }}</th>
                        <th>{{ __('invoice_item.quantity') }}</th>
                        <th>{{ __('invoice_item.price') }}</th>
                        <th>{{ __('invoice_item.amount') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoiceItems as $invoiceItem)
                        @php /* @var \App\InvoiceItem $invoiceItem */ @endphp
                        <tr class="font-verdana">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $invoiceItem->getItemName() }}</td>
                            <td class="text-center">{{ $invoiceItem->getQuantity() }}</td>
                            <td class="text-center">{{ $invoiceItem->getAmount() }}</td>
                            <td class="text-center">{{ $invoiceItem->getAmount() * $invoiceItem->getQuantity() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    
    <div style="margin-top:5rem;">
        <div style="display: flex;width: 100%;">
            <div style="background-color: #c2e0f4;width:48%;float:left;padding:5px 20px;border:none;">
                <div style="flex: 1;color: #5c5757;font-family:'Calibri';">
                    <p style="font-size: 14px; line-height: 140%;"><strong><span style="font-size: 14px; line-height: 19.6px;">{{ __('invoice_item.notes') }}:</span></strong></p>
                    <p style="font-size: 14px; line-height: 140%;"><span style="font-size: 12px; line-height: 16.8px;">- {{ __('invoice_item.notes1') }}</span></p>
                    <p style="font-size: 14px; line-height: 140%;"><span style="font-size: 12px; line-height: 16.8px;">- {{ __('invoice_item.notes2') }}</span></p>
                    <p style="font-size: 14px; line-height: 140%;"><span style="font-size: 12px; line-height: 16.8px;">- {{ __('invoice_item.notes3') }}</span></p>
                </div>
            </div>
        
            <div style="background-color: #054169;width:46.5%;height:159px;float:left;border:none;position:relative;">
                <div style="flex: 1;color: #ffffff;position: absolute;top: 74px;font-family:Arial;">
                    <p style="font-size: 14px; line-height: 140%; text-align: right;padding-right: 26px;"><strong><span style="font-size: 16px; line-height: 19.6px;">{{ __('invoice_item.total') }}</span></strong></p>
                    <p style="font-size: 14px; line-height: 140%; text-align: right;padding-right: 12px;"><span style="font-size: 26px; line-height: 36.4px;"><strong><span style="line-height: 36.4px; font-size: 46px;">{{ __('invoice_item.currency') }}{{ number_format($invoice->getPaidAmount(), 2) }} </span></strong></span></p>
                </div>
            </div>
        </div>
    </div>
    <br>
    
    <div class="row" style="clear:both;">
        <div class="col-sm-12 mt-5 text-center">
            <h1 class="font-verdana" style="font-weight:normal;">{{ __('common.thank_you') }}.</h1>
        </div>
    </div>
</body>
</html>

