<?php

namespace App\Http\Controllers\Member;

use App\Enumeration\PolicyActionEnum;
use App\Http\Controllers\Controller;
use App\Menu;
use App\MenuTranslation;
use App\Service\Member\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    private $menuService;

    /**
     * Create a new controller instance.
     *
     * @param MenuService $menuService
     */
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
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
        $this->authorize(PolicyActionEnum::INDEX, Menu::class);

        $title = trans_choice('entity.menu', 2);
        $menuRecords = $this->menuService->getListing($request);

        $menus = [];
        if (count($menuRecords)) {
            foreach ($menuRecords as $key => $menu) {
                /* @var Menu $menu */
                $menus[(is_null($menu->getParentId()) ? 0 : $menu->getParentId())][] = $menu;
            }
        }

        return view('member.menu.list.list', compact('title', 'menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize(PolicyActionEnum::CREATE, Menu::class);

        $menu = new Menu();
        $title = __('form.add_new_record');
        return view('member.menu.form', compact('title', 'menu'));
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
        $this->authorize(PolicyActionEnum::CREATE, Menu::class);

        $menu = new Menu();

        // validation
        $validator = $this->menuService->validate($menu, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $menu = $this->menuService->save($menu, $request);

        return $this->menuService->saveAfterAction($request, $menu)
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
     * @param Menu $menu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Menu $menu)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $menu);

        /* @var MenuTranslation $menuTranslation */
        $menuTranslation = $menu->menuTranslation(app('Language')->getId())->first();

        $title = 'Edit ' . $menuTranslation->getName();
        return view('member.menu.form', compact('title', 'menu', 'menuTranslation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Menu    $menu
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Menu $menu, Request $request)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $menu);

        // validation
        $validator = $this->menuService->validate($menu, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $menu = $this->menuService->save($menu, $request);

        return $this->menuService->saveAfterAction($request, $menu)
            ->with('status', __('message.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Menu    $menu
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Menu $menu, Request $request)
    {
        $this->authorize(PolicyActionEnum::DELETE, $menu);

        $this->menuService->delete($menu, $request);

        return back()->with('status', __('message.record_deleted'));
    }

    public function sortable(Request $request)
    {
        $ordering = $request->input('ordering');
        if (!empty($ordering)) {
            $this->menuService->sortAndUpdateParent($ordering);
        }
        return $request->input('ordering');
    }
}
