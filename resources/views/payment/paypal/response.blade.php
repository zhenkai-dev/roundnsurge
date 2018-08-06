@extends('web.layouts.app', [
    'browserTitle' => 'Payment status',
    'bodyClass' => 'payment-response'
])

@section('content')
    <div class="container">
        <div class="py-5">
            <div class="text-center">
                @if ($status === 'success')
                    <h1 class="text-uppercase">Payment success</h1>
                    Your payment has been paid successfully.
                @else
                    <h1 class="text-uppercase">Payment failed</h1>
                    <div>We're sorry your payment has been failed to process.</div>
                    <div>Please contact our administrator via <a href="mailto:{{ setting()->getEnquiryReceiver() }}">{{ setting()->getEnquiryReceiver() }}</a> for assist.</div>
                @endif
            </div>
        </div>
    </div>
@endsection