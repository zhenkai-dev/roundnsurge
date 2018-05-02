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
            <h1>News</h1>

            @if (count($newsList))
                <div class="news">
                    <div class="row">
                        @foreach ($newsList as $news)
                            <div class="col-sm-12 col-md-6 col-lg-4 item">
                                <div class="item-container">
                                    @if ($news->getPhoto())
                                        <a href="{{ route('web.news.show', ['slug' => $news->friendly_url_name]) }}" class="img-top" style="background-image: url('{{ $news->getPhotoFullUrl() }}')"></a>
                                    @else
                                        <a href="{{ route('web.news.show', ['slug' => $news->friendly_url_name]) }}" class="no-image">
                                            <span>News</span>
                                        </a>
                                    @endif
                                    <div class="item-body">
                                        <h5 class="heading">
                                           {{ $news->news_name }}
                                        </h5>

                                        <div class="text-muted post-date">{{ $news->getPostDate()->toFormattedDateString() }}</div>

                                        <a href="{{ route('web.news.show', ['slug' => $news->friendly_url_name]) }}" class="btn btn-theme">Read more</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{ $newsList->links() }}
                </div>
            @else
                <div>Now news updated yet.</div>
            @endif
        </div>
    </div>
@endsection
