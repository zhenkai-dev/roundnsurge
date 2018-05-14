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
    @if (!empty($banners) && count($banners) == 1)
        <div id="banner">
            <div class="banner-swiper">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($banners as $banner)
                            @php
                                /* @var \App\Banner $banner */
                                // $banner with [banner_name, banner_description, friendly_url_name, friendly_url_module]
                            @endphp

                            <div class="swiper-slide" style="background-image: url({{ $banner->getPhotoFullUrl() }})">
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

    <div class="chart home-section">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4 mb-3">
                    <div class="heading">
                        R&S PORTFOLIO
                    </div>
                    <p>Lorem ipsum dolor sit
                        amet, consectetur
                        adipiscing elit. Non autem
                        hoc: igitur ne illud quidem.</p>
                </div>
                <div class="col-lg-8">
                    [EMBED CHART API]

                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 mb-3">
                    <div class="heading">
                        R&S PORTFOLIO
                    </div>
                    <p>Lorem ipsum dolor sit
                        amet, consectetur
                        adipiscing elit. Non autem
                        hoc: igitur ne illud quidem.</p>
                </div>
                <div class="col-lg-8">
                    [EMBED CHART API]

                </div>
            </div>
        </div>
    </div>

    <div class="middle-banner home-section">
        <div class="container py-5">
            <img class="img-fluid" src="{{ asset('web/images/banner.jpg') }}">
        </div>
    </div>

    @if(!empty($packages) && count($packages))
        <div class="package-section">
            <div class="container py-5">
                <h3 class="heading text-center">Training</h3>

                <div class="packages">
                    <div class="row">
                        @foreach ($packages as $package)
                            @php /* @var \App\Package $package with [package_name, package_description] */ @endphp
                            <div class="col-md-4 item {{ ($package->getPackageType() == \App\Package::MEMBER) ? 'highlight' : '' }}">
                                <div class="item-container text-center px-lg-5 px-3">
                                    <div>{{ $package['package_name'] }}</div>
                                    <div class="price">{{ ($package->getPrice() == 0 ? 'FREE' : currency($package->getPrice())) }}</div>
                                    <p class="description">
                                        {{ nl2br($package['package_description']) }}
                                    </p>
                                    <a class="text-uppercase btn btn-theme" href="{{ route('web.register', ['package' => $package->getId()]) }}">Sign Up</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="testimonial-section">
        <div class="container py-5">
            <div class="mb-5">
                <h3 class="heading text-center">TESTIMONIAL</h3>
                <h4 class="sub-heading text-center">
                    Over 3,000 people have already taken the course and
                    are getting results. Here's what a few of them had to say...
                </h4>
            </div>

            <div class="testimonials">
                <div class="row">
                    <div class="item col-sm-12 col-md-6 col-lg-4">
                        <div class="item-container">
                            <div class="description">
                                There is more material than I was expecting in the course. The videos are extremely helpful and the mix of presenters and ideas is outstanding.

                                <div class="author">- Zbig Skiba, Selangor</div>
                            </div>
                        </div>
                    </div>

                    <div class="item col-sm-12 col-md-6 col-lg-4">
                        <div class="item-container">
                            <div class="description">
                                There is more material than I was expecting in the course. The videos are extremely helpful and the mix of presenters and ideas is outstanding.

                                <div class="author">- Zbig Skiba, Selangor</div>
                            </div>
                        </div>
                    </div>

                    <div class="item col-sm-12 col-md-6 col-lg-4">
                        <div class="item-container">
                            <div class="description">
                                There is more material than I was expecting in the course. The videos are extremely helpful and the mix of presenters and ideas is outstanding.

                                <div class="author">- Zbig Skiba, Selangor</div>
                            </div>
                        </div>
                    </div>

                    <div class="item col-sm-12 col-md-6 col-lg-4">
                        <div class="item-container">
                            <div class="description">
                                There is more material than I was expecting in the course. The videos are extremely helpful and the mix of presenters and ideas is outstanding.

                                <div class="author">- Zbig Skiba, Selangor</div>
                            </div>
                        </div>
                    </div>

                    <div class="item col-sm-12 col-md-6 col-lg-4">
                        <div class="item-container">
                            <div class="description">
                                There is more material than I was expecting in the course. The videos are extremely helpful and the mix of presenters and ideas is outstanding.

                                <div class="author">- Zbig Skiba, Selangor</div>
                            </div>
                        </div>
                    </div>

                    <div class="item col-sm-12 col-md-6 col-lg-4">
                        <div class="item-container">
                            <div class="description">
                                There is more material than I was expecting in the course. The videos are extremely helpful and the mix of presenters and ideas is outstanding.

                                <div class="author">- Zbig Skiba, Selangor</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection