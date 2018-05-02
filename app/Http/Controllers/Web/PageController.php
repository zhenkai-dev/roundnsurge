<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 6/4/2018
 * Time: 2:09 PM
 */

namespace App\Http\Controllers\Web;


use App\FriendlyUrl;
use App\Http\Controllers\Controller;
use App\Page;
use App\Service\Admin\PageService;

class PageController extends Controller
{
    private $pageService;

    /**
     * Create a new controller instance.
     *
     * @param PageService $pageService
     */
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * Display the specified resource.
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $friendlyUrl = FriendlyUrl::whereName($slug)
            ->whereModule(Page::class)
            ->firstOrFail();

        $page = $friendlyUrl->friendlyUrlOwned()->where('is_active', '=', true)->firstOrFail();

        /* @var \App\Page $page */
        $pageTranslation = $page->pageTranslation(app('Language')->getId())->first();

        return view('web.pages.page.view', compact('page', 'pageTranslation'));
    }
}