@extends('admin.layouts.app-listing')

@section('heading')
    {!! $title !!}
@endsection

@section('listing')
    @php /* @var Illuminate\Pagination\LengthAwarePaginator $invoices */ @endphp

    @component('admin.shared.listing.listing-header-component', ['module' => \App\Invoice::class])
        @slot('total') {{ $invoices->total() }} @endslot
        @section('add_new_invoice')
            <a href="{{ route('admin.invoice.form') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> {{ __('common.add_new') }}</a>
        @endsection
    @endcomponent

    @component('admin.shared.listing.filter-form')
        @slot('action') {{ route('admin.invoice.index') }} @endslot
        @slot('inputs')
            @component('admin.shared.listing.filter-form-group')
                @slot('label') {{ __('invoice.invoice_no') }} @endslot
                @slot('input')
                    @component('admin.shared.input.text-component')
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
                    <th>{{ trans_choice('entity.member', 1) }}</th>
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
                        <td>{{ $invoice->member->getName() }}</td>
                        <td>{{ currency($invoice->getAmount()) }}</td>
                        <td>{{ $invoice->getPaidDate()->setTimezone(session('timezone'))->toDayDateTimeString() }}</td>
                        <td class="text-center">
                            @if (!Auth::user()->can(\App\Enumeration\PolicyActionEnum::VIEW, $invoice))
                                {!! view_icon_muted() !!}
                            @else
                                {!! view_icon_link(route('admin.invoice.show', $invoice->getId())) !!}
                                &nbsp;
                                <a class="d-inline-block text-info" href="{{ route('admin.download.as.pdf', $invoice->getId()) }}">
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
