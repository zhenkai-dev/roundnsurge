@extends('member.layouts.app')

@section('content')
    @yield('notification')
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> @yield('heading')
                    </div>
                    <div class="card-block">
                        @php /* @var \Illuminate\Support\ViewErrorBag $errors */ @endphp
                        @if (count($errors))
                            @component('member.shared.alert-component')
                                @slot('type') danger @endslot

                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            @endcomponent
                        @elseif (session('status'))
                            @component('member.shared.alert-component')
                                @slot('type') success @endslot

                                {{ session('status') }}
                            @endcomponent
                        @endif

                        @yield('listing')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection