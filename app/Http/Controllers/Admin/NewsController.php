<?php

namespace App\Http\Controllers\Admin;

use App\Enumeration\PolicyActionEnum;
use App\FriendlyUrl;
use App\Http\Controllers\Controller;
use App\News;
use App\NewsTranslation;
use App\Service\Admin\NewsService;
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

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize(PolicyActionEnum::INDEX, News::class);

        $title = trans_choice('entity.news', 2);
        $newsList = $this->newsService->getListing($request);

        return view('admin.news.list', compact('title', 'newsList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize(PolicyActionEnum::CREATE, News::class);

        $news = new News();
        $title = __('form.add_new_record');
        return view('admin.news.form', compact('title', 'news'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        $this->authorize(PolicyActionEnum::CREATE, News::class);

        $news = new News();

        // validation
        $validator = $this->newsService->validate($news, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $news = $this->newsService->save($news, $request);

        return $this->newsService->saveAfterAction($request, $news)
            ->with('status', __('message.record_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param News $news
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(News $news)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $news);

        /* @var NewsTranslation $newsTranslation */
        $newsTranslation = $news->newsTranslation(app('Language')->getId())->first();

        /* @var FriendlyUrl $friendlyUrl */
        $friendlyUrl = $news->friendlyUrl()->first();

        $title = 'Edit ' . $newsTranslation->getName();
        return view('admin.news.form', compact('title', 'news', 'newsTranslation', 'friendlyUrl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param News    $news
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(News $news, Request $request)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $news);

        // validation
        $validator = $this->newsService->validate($news, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $news = $this->newsService->save($news, $request);

        return $this->newsService->saveAfterAction($request, $news)
            ->with('status', __('message.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param News    $news
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(News $news, Request $request)
    {
        $this->authorize(PolicyActionEnum::DELETE, $news);

        $this->newsService->delete($news, $request);

        return back()->with('status', __('message.record_deleted'));
    }
}
