@extends('web.layouts.app', [
    'browserTitle' => $pageTranslation->getMetaTitle(),
    'metaKeywords' => $pageTranslation->getMetaKeywords(),
    'metaDescription' => $pageTranslation->getMetaDescription(),
    'bodyClass' => 'home'
])

@section('styles')
    <link href="{{ asset('web/css/swiper.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    @if (count($banners) == 1)
        <div id="banner">
            <div class="banner-swiper">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($banners as $banner)
                            @php
                                /* @var \App\Banner $banner */
                                // $banner with [banner_name, banner_description, friendly_url_name, friendly_url_module]
                            @endphp

                            <div class="swiper-slide">
                                <div class="container">
                                    @if (!empty($banner['banner_name']))
                                        <h1>{{ $banner['banner_name'] }}</h1>
                                    @endif

                                    @if (!empty($banner['banner_description']))
                                        <p>{{ nl2br($banner['banner_description']) }}</p>
                                    @endif

                                    @if (!empty($banner->getUrl()) || !empty($banner->getUrlId()))
                                        <a href="{{ get_site_url(new \App\Dto\UrlDto($banner['friendly_url_id'], $banner['friendly_url_name'], $banner['friendly_url_module'], $banner->getUrl())) }}" class="btn btn-theme">Read more</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Add Arrows -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    @endif

    <div class="about home-section bg-white">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-3 col-lg-2 mb-3">
                    <div class="heading">
                        About <span class="d-md-block">OWL</span>
                    </div>
                </div>
                <div class="col-md-9 col-lg-10">
                    <h2>We are a Digital Agency for Retail</h2>
                    <p>From strategic planning, web system development, eCommerce, branding and
                        creative development, marketing services to omni-channel integration, we help
                        our clients to move business online as well as providing seamless shopping
                        experience for their customers. </p>
                    <a href="" class="btn btn-theme">Read More</a>

                </div>
            </div>
        </div>
    </div>

    <div class="what-we-do home-section bg-light">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-3 col-lg-2 mb-3 order-md-1">
                    <div class="heading">
                        What <span class="d-md-block">We Do</span>
                    </div>
                </div>
                <div class="col-md-9 col-lg-10">
                    <div class="service">
                        <div class="row">
                            <div class="col-sm-6 item">
                                <h3 class="title">
                                    Strategic Planning
                                </h3>
                                <div class="description">
                                    Provide you IT and creative solutions
                                    that work best for your business.
                                </div>
                            </div>
                            <div class="col-sm-6 item">
                                <h3 class="title">
                                    PHOTOGRAPHY
                                </h3>
                                <div class="description">
                                    We take professional photos of products
                                    and models for your brand and business.
                                </div>
                            </div>
                            <div class="col-sm-6 item">
                                <h3 class="title">
                                    Branding & Design
                                </h3>
                                <div class="description">
                                    We create the best user interface design, logo and
                                    branding visual identity for business.
                                </div>
                            </div>
                            <div class="col-sm-6 item">
                                <h3 class="title">
                                    Web Development
                                </h3>
                                <div class="description">
                                    From content management system to CRM,
                                    we can develop all you want.
                                </div>
                            </div>
                            <div class="col-sm-6 item">
                                <h3 class="title">
                                    eCommerce Development
                                </h3>
                                <div class="description">
                                    We are experienced in Shopify, Bigcommerce,
                                    Magento as well as build your shop from scratch.
                                </div>
                            </div>
                            <div class="col-sm-6 item">
                                <h3 class="title">
                                    System Integration
                                </h3>
                                <div class="description">
                                    New retail is the future, we provide seamless
                                    integration between online and retail business.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="happy-client bg-white">
        <div class="container py-5">
            <h2 class="text-center mb-3">Happy Clients</h2>
            <div class="logos">
                <div class="row">
                    <div class="col-6 col-sm-4 col-lg-2 mb-4">
                        <div class="item h-100 align-items-center d-flex justify-content-center">
                            <img class="img-fluid" src="{{ asset('web/images/clients/180.png') }}" title="" alt="">
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2 mb-4">
                        <div class="item h-100 align-items-center d-flex justify-content-center">
                            <img class="img-fluid" src="{{ asset('web/images/clients/tapir.png') }}" title="" alt="">
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2 mb-4">
                        <div class="item h-100 align-items-center d-flex justify-content-center">
                            <img class="img-fluid" src="{{ asset('web/images/clients/lensvillage.png') }}" title=""
                                 alt="">
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2 mb-4">
                        <div class="item h-100 align-items-center d-flex justify-content-center">
                            <img class="img-fluid" src="{{ asset('web/images/clients/hspace.png') }}" title="" alt="">
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2 mb-4">
                        <div class="item h-100 align-items-center d-flex justify-content-center">
                            <img class="img-fluid" src="{{ asset('web/images/clients/desensez.png') }}" title="" alt="">
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2 mb-4">
                        <div class="item h-100 align-items-center d-flex justify-content-center">
                            <img class="img-fluid" src="{{ asset('web/images/clients/oldtown.png') }}" title="" alt="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-4 col-lg-2 mb-4">
                        <div class="item h-100 align-items-center d-flex justify-content-center">
                            <img class="img-fluid" src="{{ asset('web/images/clients/eco-tropic.png') }}" title=""
                                 alt="">
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2 mb-4">
                        <div class="item h-100 align-items-center d-flex justify-content-center">
                            <img class="img-fluid" src="{{ asset('web/images/clients/waiko.png') }}" title="" alt="">
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2 mb-4">
                        <div class="item h-100 align-items-center d-flex justify-content-center">
                            <img class="img-fluid" src="{{ asset('web/images/clients/fuji-pacific.png') }}" title=""
                                 alt="">
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2 mb-4">
                        <div class="item h-100 align-items-center d-flex justify-content-center">
                            <img class="img-fluid" src="{{ asset('web/images/clients/search-asia.png') }}" title=""
                                 alt="">
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2 mb-4">
                        <div class="item h-100 align-items-center d-flex justify-content-center">
                            <img class="img-fluid" src="{{ asset('web/images/clients/sklas.png') }}" title="" alt="">
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2 mb-4">
                        <div class="item h-100 align-items-center d-flex justify-content-center">
                            <img class="img-fluid" src="{{ asset('web/images/clients/emum.png') }}" title="" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="testimonial home-section bg-light">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="heading">
                        Real People, <span class="d-md-block">Real Result</span>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="testimonial-swiper">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">Slide 1</div>
                                <div class="swiper-slide">Slide 2</div>
                                <div class="swiper-slide">Slide 3</div>
                                <div class="swiper-slide">Slide 4</div>
                                <div class="swiper-slide">Slide 5</div>
                                <div class="swiper-slide">Slide 6</div>
                                <div class="swiper-slide">Slide 7</div>
                                <div class="swiper-slide">Slide 8</div>
                                <div class="swiper-slide">Slide 9</div>
                                <div class="swiper-slide">Slide 10</div>
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="request-consultation bg-theme">
        <div class="container py-5">
            <h3 class="text-center mb-4">We provide you the best solution for your online and retail business.</h3>
            <div class="text-center">
                <a href="" class="btn btn-red">Request A Free Consultation</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('web/js/swiper.min.js') }}"></script>
    <script>

        if ($('#banner').length) {
            new Swiper('#banner .swiper-container', {
                navigation: {
                    nextEl: '#banner .swiper-button-next',
                    prevEl: '#banner .swiper-button-prev'
                }
            });
        }

        new Swiper('.testimonial-swiper .swiper-container', {
            navigation: {
                nextEl: '.testimonial-swiper .swiper-button-next',
                prevEl: '.testimonial-swiper .swiper-button-prev'
            }
        });
    </script>
@endsection