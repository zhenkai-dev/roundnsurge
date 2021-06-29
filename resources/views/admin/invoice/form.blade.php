@extends('admin.layouts.app-form')

@section('heading')
    {!! $title !!}
@endsection

@section('form')

    @php /* @var \App\Invoice $invoice */ @endphp
    @php /* @var \App\InvoiceItems $InvoiceItems */ @endphp
    <form class="form-horizontal form-validation" action="{{route('admin.invoice.store')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}

        @component('admin.shared.form.form-group')
            @slot('label') {{ __('common.orderNo') }} @endslot
            @slot('input')
                @component('admin.shared.input.template.orders-list-component', [])
                    @slot('name') order_id @endslot
                @endcomponent
            @endslot
        @endcomponent

        @include('admin.shared.form.form-submit-button')
    </form>
@endsection
