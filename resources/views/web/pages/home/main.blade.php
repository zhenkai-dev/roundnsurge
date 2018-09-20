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

    @php /* @var \App\Page[] $pages */ @endphp

    @if (!empty($banners) && count($banners) > 0)
        <div id="banner">
            <div class="container">
                <div class="banner-swiper">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            @foreach($banners as $banner)
                                @php
                                    /* @var \App\Banner $banner */
                                    // $banner with [banner_name, banner_description, friendly_url_name, friendly_url_module]
                                @endphp

                                <div class="swiper-slide"
                                     style="background-image: url({{ $banner->getPhotoFullUrl() }})">
                                    <div class="">
                                        @if (!empty($banner['banner_name']))
                                            <h1>{{ $banner['banner_name'] }}</h1>
                                        @endif

                                        @if (!empty($banner['banner_description']))
                                            <p>{{ nl2br($banner['banner_description']) }}</p>
                                        @endif

                                        @if (!empty($banner->getUrl()) || !empty($banner->getUrlId()))
                                            <a href="{{ get_site_url(new \App\Dto\UrlDto($banner['friendly_url_id'], $banner['friendly_url_name'], $banner['friendly_url_module'], $banner->getUrl())) }}"
                                               class="btn btn-theme">Read more</a>
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
        </div>
    @endif

    <div class="chart home-section">
        <div class="container py-5">
            @php /* @var \App\PageTranslation $pageTranslation */ @endphp
            {!! editor_content($pageTranslation->getDescription()) !!}
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
                                    <div class="name">{{ $package['package_name'] }}</div>
                                    <div class="price">{{ ($package->getPrice() == 0 ? 'FREE' : currency($package->getPrice())) }}</div>
                                    <p class="description">
                                        {{ nl2br($package['package_description']) }}
                                    </p>
                                    <a class="text-uppercase btn btn-theme btn-lg btn-action"
                                       href="{{ route('web.register', ['package' => $package->getId()]) }}">Sign Up</a>
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
                @if (!empty($pages[6]))
                    <h4 class="sub-heading text-center">
                        {!! editor_content($pages[6]->pageTranslation->getDescription()) !!}
                    </h4>
                @endif
            </div>

            @if (!empty($pages[7]))
                <div class="testimonials">
                    {!! editor_content($pages[7]->pageTranslation->getDescription()) !!}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('web/js/swiper.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/canvasjs/1.7.0/canvasjs.min.js"></script>
    <script>

        if ($('#banner').length) {
            new Swiper('#banner .swiper-container', {
                navigation: {
                    nextEl: '#banner .swiper-button-next',
                    prevEl: '#banner .swiper-button-prev'
                }
            });
        }

        var stockLiveCount = $('#stock-table-live li').length;
        if (stockLiveCount) {
            $('#stock-table-live').after('<div id="table-stock-live" class="table-responsive"></div>');
            $('#table-stock-live').html('' +
                '<table class="table table-stock table-striped">' +
                '<thead>' +
                '<tr>' +
                '<th>Company</th>' +
                '<th>Date</th>' +
                '<th>Buy</th>' +
                '<th>Live Price</th>' +
                '<th>Profit / Loss</th>' +
                '<th>Profit / Loss (%)</th>' +
                '</tr' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
                '</table>');

            $('#stock-table-live li').each(function () {
                var $this = $(this);
                var stockData = $this.html();
                var stockNameReg = /[^\[]+?(?=\])/;
                var stockName = stockNameReg.exec(stockData);

                var stockSymbolReg = new RegExp('(?<=\\[' + stockName + '\\]).*?(?=\\s)', 'g');
                var stockSymbol = stockSymbolReg.exec(stockData);

                var stockDateReg = /(?<=DATE\:).*?(?=\s)/;
                var stockDate = stockDateReg.exec(stockData);

                var stockBuyReg = /(?<=BUY\:).*?(?=\s)/;
                var stockBuy = parseFloat(stockBuyReg.exec(stockData).toString());

                var stockCloseReg = /(?<=CLOSE\:).*/;
                var stockClose = parseFloat(stockCloseReg.exec(stockData).toString());

                var isProfit = false;
                var profit = stockClose - stockBuy;
                var profitPercentage = profit / stockBuy * 100;
                if (profit >= 0) {
                    isProfit = true;
                }

                $('#table-stock-live tbody').append($('<tr>' +
                    '<td class="name">' + stockName + '</td>' +
                    '<td class="date">' + stockDate + '</td>' +
                    '<td class="text-center ' + (isProfit ? 'text-success' : 'text-danger') + '">' + stockBuy + '</td>' +
                    '<td class="text-center ' + (isProfit ? 'text-success' : 'text-danger') + '">' + stockClose + '</td>' +
                    '<td class="text-center ' + (isProfit ? 'text-success' : 'text-danger') + '">' + profit + '</td>' +
                    '<td class="text-center ' + (isProfit ? 'text-success' : 'text-danger') + '">' + (profitPercentage !== 'N/A' ? profitPercentage.toFixed(2) + '%' : profitPercentage) + '</td>' +
                    '</tr>'));
            });
        }

        var stockSellCount = $('#stock-table-sell li').length;
        if (stockSellCount) {
            $('#stock-table-sell').after('<div id="table-stock-sell" class="table-responsive"></div>');
            $('#table-stock-sell').html('' +
                '<table class="table table-stock table-striped">' +
                '<thead>' +
                '<tr>' +
                '<th>Company</th>' +
                '<th>Date</th>' +
                '<th>Buy</th>' +
                '<th>Sell</th>' +
                '<th>Profit / Loss</th>' +
                '<th>Profit / Loss (%)</th>' +
                '</tr' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
                '</table>');

            var stockSellList = [];
            var accumulatedProfit = 0;
            $('#stock-table-sell li').each(function () {
                var $this = $(this);
                var stockData = $this.html();
                var stockNameReg = /[^\[]+?(?=\])/;
                var stockName = stockNameReg.exec(stockData);

                var stockSymbolReg = new RegExp('(?<=\\[' + stockName + '\\]).*?(?=\\s)', 'g');
                var stockSymbol = stockSymbolReg.exec(stockData);

                var stockDateReg = /(?<=DATE\:).*?(?=\s)/;
                var stockDate = stockDateReg.exec(stockData);

                var stockBuyReg = /(?<=BUY\:).*?(?=\s)/;
                var stockBuy = parseFloat(stockBuyReg.exec(stockData).toString());

                var stockSellReg = /(?<=SELL\:).*/;
                var stockSell = parseFloat(stockSellReg.exec(stockData).toString());

                var isProfit = false;
                var profit = stockSell - stockBuy;
                accumulatedProfit += profit;
                var profitPercentage = profit / stockBuy * 100;
                if (profitPercentage >= 0) {
                    isProfit = true;
                }

                $('#table-stock-sell tbody').append($('<tr>' +
                    '<td class="name">' + stockName + '</td>' +
                    '<td class="date">' + stockDate + '</td>' +
                    '<td class="text-center ' + (isProfit ? 'text-success' : 'text-danger') + '">' + stockBuy + '</td>' +
                    '<td class="text-center ' + (isProfit ? 'text-success' : 'text-danger') + '">' + stockSell + '</td>' +
                    '<td class="text-center ' + (isProfit ? 'text-success' : 'text-danger') + '">' + profit + '</td>' +
                    '<td class="text-center ' + (isProfit ? 'text-success' : 'text-danger') + '">' + (profitPercentage !== 'N/A' ? profitPercentage.toFixed(2) + '%' : profitPercentage) + '</td>' +
                    '</tr>'));

                stockSellList.push({
                    name: stockName,
                    symbol: stockSymbol,
                    date: stockDate,
                    buy: stockBuy,
                    sell: stockSell,
                    profit: accumulatedProfit
                });
            });

            var chartData = [];
            stockSellList.forEach((stockSell) => {
                chartData.push({
                    x: new Date(stockSell.date),
                    y: stockSell.profit,
                    name: stockSell.name
                })
            });

            var chart = new CanvasJS.Chart("stockSellChart", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Stock"
                },
                axisX: {
                    valueFormatString: "DD MMM",
                    crosshair: {
                        enabled: true,
                        snapToDataPoint: true
                    }
                },
                axisY: {
                    title: "Accumulated Profits",
                    crosshair: {
                        enabled: true
                    }
                },
                toolTip: {
                    content:"{x}<br />{name}: RM{y}" ,
                },
                legend: {
                    cursor: "pointer",
                    verticalAlign: "bottom",
                    horizontalAlign: "left",
                    dockInsidePlotArea: true
                },
                data: [{
                    type: "line",
                    showInLegend: true,
                    name: "Accumulated Profits",
                    markerType: "square",
                    xValueFormatString: "DD MMM, YYYY",
                    dataPoints: chartData
                }]
            });
            chart.render();
        }
    </script>
@endsection