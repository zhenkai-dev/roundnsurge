<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 11/4/2018
 * Time: 11:48 PM
 */
?>

@php
    /* @var \App\NewsTranslation $newsTranslation */
    /* @var \App\News $news */
@endphp

@extends('web.layouts.app', [
    'browserTitle' => $newsTranslation->getMetaTitle(),
    'metaKeywords' => $newsTranslation->getMetaKeywords(),
    'metaDescription' => $newsTranslation->getMetaDescription(),
    'bodyClass' => 'news-view'
])

@section('content')
    <div class="container">
        <div class="py-5">
            <h1>{{ $newsTranslation->getName() }}</h1>

            {!! editor_content($newsTranslation->getDescription()) !!}
        </div>
    </div>
@endsection