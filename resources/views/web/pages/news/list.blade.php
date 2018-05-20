<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 21/4/2018
 * Time: 5:00 PM
 */
?>

@php
    /* @var \Illuminate\Pagination\LengthAwarePaginator|\App\News[] $newsList */
@endphp

@extends('web.layouts.app', [
    'browserTitle' => 'News',
    'bodyClass' => 'news-list'
])

@section('content')
    <div class="container">
        <div class="py-5">
            <div class="row">
                <div class="col-sm-8">
                    @if (count($newsList))
                        <div class="news">
                            @foreach ($newsList as $news)
                                <div class="mb-5">
                                    <h2><a class="text-theme text-uppercase" href="{{ route('web.news.show', ['slug' => $news->friendly_url_name]) }}">{{ $news->news_name }}</a></h2>
                                    <div class="text-muted post-date">Added on {{ $news->getPostDate()->toFormattedDateString() }}</div>
                                    <p>{{ $news->news_short_intro }}</p>
                                    <a class="font-weight-bold text-theme" href="{{ route('web.news.show', ['slug' => $news->friendly_url_name]) }}">Read More <i class="fa fa-chevron-right"></i></a>
                                </div>
                            @endforeach

                            {{ $newsList->links() }}
                        </div>
                    @else
                        <div>Now news updated yet.</div>
                    @endif
                </div>
                <div class="col-sm-4">
                    @include('web.shared.page-sidebar-component')
                </div>
            </div>
        </div>
    </div>
@endsection
