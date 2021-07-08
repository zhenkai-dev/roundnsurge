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
                    @php /* @var \Illuminate\Support\ViewErrorBag $errors */ @endphp
                    @if (count($errors))
                        @component('web.shared.alert-component')
                            @slot('type') danger @endslot

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @endcomponent
                    @elseif (session('status'))
                        @component('web.shared.alert-component')
                            @slot('type') success @endslot

                            {{ session('status') }}
                        @endcomponent
                    @endif

                    {!! editor_content($pageTranslation->getDescription()) !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script></script>
@endsection