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
                <h1 class="text-uppercase">{{ $pageTranslation->getName() }}</h1>
            </div>
        </div>
    @endif

    <div class="container">
        <div class="py-5">
            <div class="row">
                <div class="col-sm-8">
                    @if (!$page->getPhoto())
                        <h1 class="text-theme text-uppercase">{{ $pageTranslation->getName() }}</h1>
                    @endif

                    <div class="page-content">
                        {!! editor_content($pageTranslation->getDescription()) !!}
                    </div>

                    @if ($page->id == 14)
                        @include('web.shared.contact-form')
                    @endif
                </div>
                <div class="col-sm-4">
                    @include('web.shared.page-sidebar-component')
                </div>
            </div>
        </div>
    </div>
@endsection