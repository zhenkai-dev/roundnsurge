<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Page;
use App\Service\Web\BannerService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $banners = BannerService::getAll();

        $page = Page::find(1)->where('is_active', true)->first();

        /* @var \App\Page $page */
        $pageTranslation = $page->pageTranslation(app('Language')->getId())->first();

        return view('web.pages.home.main', compact('banners', 'page', 'pageTranslation'));
    }
}
