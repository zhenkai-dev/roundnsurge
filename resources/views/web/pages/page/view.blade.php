<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 11/4/2018
 * Time: 11:48 PM
 */
?>

@php
    /* @var \App\PageTranslation $pageTranslation */
    /* @var \App\Page $page */
@endphp

@extends('web.layouts.app', [
    'browserTitle' => $pageTranslation->getMetaTitle(),
    'metaKeywords' => $pageTranslation->getMetaKeywords(),
    'metaDescription' => $pageTranslation->getMetaDescription(),
    'bodyClass' => 'page-view'
])

@section('content')

    @if ($page->getPhoto())
        <div class="banner" style="background-image: url('{{ $page->getPhotoFullUrl() }}')">
            <div class="container">
                <h1>{{ $pageTranslation->getName() }}</h1>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="py-5">
            @if (!$page->getPhoto())
                <h1>{{ $pageTranslation->getName() }}</h1>
            @endif

            {!! editor_content($pageTranslation->getDescription()) !!}
        </div>
    </div>
@endsection