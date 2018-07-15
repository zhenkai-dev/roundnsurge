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
            <div class="row">
                <div class="col-sm-8">
                    <h1 class="text-theme text-uppercase">{{ $newsTranslation->getName() }}</h1>

                    <div class="page-content">
                        {!! editor_content($newsTranslation->getDescription()) !!}
                    </div>
                </div>
                <div class="col-sm-4">
                    @include('web.shared.page-sidebar-component')
                </div>
            </div>
        </div>
    </div>
@endsection