@extends('member.layouts.app')

@section('content')
    <h1>Welcome!</h1>
    <p>In order to proceed, please send us an email at <a href="mailto:roundnsurge@gmail.com">roundnsurge@gmail.com</a> when your mplus trading account is activated.</p>
    <p>Looking forward to hear from you!</p>
@endsection

@section('script')
    <script src="{{ asset('member/js/chart.min.js') }}"></script>
@endsection
