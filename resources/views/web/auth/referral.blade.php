@extends('web.layouts.app', [
    'bodyClass' => 'auth auth-register'
])

@php
    /* @var \App\Page $registerPage */
    /* @var \App\FriendlyUrl $termsUrl */
@endphp

@section('content')
    <div class="container">
        <div class="row justify-content-center my-5 py-5">
            <div class="col-md-12">
                <div class="content">
                    <h1 class="card-title">THANK YOU FOR YOUR REGISTRATION</h1>

                    @php /* @var \Illuminate\Support\ViewErrorBag $errors */ @endphp
                    @if (count($errors))
                        @component('web.shared.alert-component')
                            @slot('type') danger @endslot

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @endcomponent
                    @elseif (count(session('status')))
                        @component('web.shared.alert-component')
                            @slot('type') success @endslot

                            {{ session('status') }}
                        @endcomponent
                    @endif

                    <p>In order to process your member registration, please sign up MPLUS account <a href="https://www.mplusonline.com.my/macsecos/index.asp" target="_blank">here</a>.</p>
                    <p>Once registered, please email to us for account validation and we will process your membership at soonest.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script></script>
@endsection