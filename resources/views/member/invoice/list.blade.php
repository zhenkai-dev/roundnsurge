@extends('member.layouts.app-listing')

@section('heading')
    {!! $title !!}
@endsection

@section('listing')
    @php /* @var Illuminate\Pagination\LengthAwarePaginator $invoices */ @endphp

    @component('member.shared.listing.listing-header-component', ['module' => \App\Invoice::class])
        @slot('total') {{ $invoices->total() }} @endslot
    @endcomponent

    @component('member.shared.listing.filter-form')
        @slot('action') {{ route('member.invoice.index') }} @endslot
        @slot('inputs')
            @component('member.shared.listing.filter-form-group')
                @slot('label') {{ __('invoice.invoice_no') }} @endslot
                @slot('input')
                    @component('member.shared.input.text-component')
                        @slot('type') text @endslot
                        @slot('name') invoice_no @endslot
                        @slot('value') {{ request('invoice_no') }} @endslot
                    @endcomponent
                @endslot
            @endcomponent
        @endslot
        @slot('pagination')
            {{ $invoices->links() }}
        @endslot
    @endcomponent

    @if (count($invoices))
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{!! sortable('name', __('invoice.invoice_no')) !!}</th>
                        <th>{{ __('invoice.amount') }}</th>
                        <th>{{ __('invoice.paid_date') }}</th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($invoices as $invoice)
                    @php /* @var App\Invoice $invoice */ @endphp
                    <tr>
                        <td>{{ $invoice->formatInvoiceNo() }}</td>
                        <td>{{ currency($invoice->getAmount()) }}</td>
                        <td>{{ $invoice->getPaidDate()->setTimezone(session('timezone'))->toDayDateTimeString() }}</td>
                        <td class="text-center">
                            @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::VIEW, $invoice))
                                {!! view_icon_muted() !!}
                            @else
                                {!! view_icon_link(route('member.invoice.show', $invoice->getId())) !!}
                                &nbsp;
                                <a class="d-inline-block text-info" href="{{ route('member.download.as.pdf', $invoice->getId()) }}">
                                    <span title="{{ __('common.download') }}" class="text-info"><i class="fa fa-download"></i>
                                    </span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning" role="alert">
            {{ __('message.no_record') }}
        </div>
    @endif

    {{ $invoices->links() }}
@endsection
