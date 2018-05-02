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
use App\News;
use App\Service\Web\NewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    private $newsService;

    /**
     * Create a new controller instance.
     *
     * @param NewsService $newsService
     */
    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index(Request $request)
    {
        $newsList = $this->newsService->getListing($request);
        return view('web.pages.news.list', compact('newsList'));
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $friendlyUrl = FriendlyUrl::whereName($slug)
            ->whereModule(News::class)
            ->firstOrFail();

        $news = $friendlyUrl->friendlyUrlOwned()->where('is_active', '=', true)->firstOrFail();

        /* @var \App\News $news */
        $newsTranslation = $news->newsTranslation(app('Language')->getId())->first();

        return view('web.pages.news.view', compact('news', 'newsTranslation'));
    }
}
