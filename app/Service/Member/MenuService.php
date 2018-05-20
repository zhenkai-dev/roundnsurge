<?php

namespace App\Service\Member;

use App\Enumeration\PolicyActionEnum;
use App\Enumeration\RouteTypeEnum;
use App\FriendlyUrl;
use App\Menu;
use App\MenuTranslation;
use App\Repository\Member\MenuRepository;
use App\Service\Member\Util\LogUtil;
use App\Service\Member\Util\SaveAfterActionUtil;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MenuService
{
    private $menuRepository;

    private $friendlyUrlService;

    public function __construct(MenuRepository $menuRepository, FriendlyUrlService $friendlyUrlService)
    {
        $this->menuRepository = $menuRepository;
        $this->friendlyUrlService = $friendlyUrlService;
    }

    /**
     * Request validation
     *
     * @param Menu    $menu
     * @param Request $request
     * @return mixed
     */
    public function validate(Menu $menu, Request $request): \Illuminate\Validation\Validator
    {
        if (route_type() == RouteTypeEnum::STORE) {
            return Validator::make($request->all(), [
                'name' => 'required|max:255',
                'url_id' => 'nullable|exists:' . FriendlyUrl::getTableName() . ',id',
                'url' => 'nullable|string',
                'target' => 'required|string',
                'is_active' => 'required|boolean'
            ]);
        } else {
            return Validator::make($request->all(), [
                'name' => 'required|max:255',
                'url_id' => 'nullable|exists:' . FriendlyUrl::getTableName() . ',id',
                'url' => 'nullable|string',
                'target' => 'required|string',
                'is_active' => 'required|boolean'
            ]);
        }
    }

    /**
     * Save entity
     *
     * @param Menu    $menu
     * @param Request $request
     * @return Menu
     */
    public function save(Menu $menu, Request $request): Menu
    {
        $isEdit = $menu->exists;

        if ($isEdit) {
            $menuTranslation = $menu->menuTranslation()->first();
        } else {
            $menuTranslation = new MenuTranslation();
        }

        $menu->setUrlId($request->input('url_id'));
        $menu->setUrl($request->input('url'));
        $menu->setTarget($request->input('target'));
        if (!$isEdit) {
            $menu->setOrdering(config('app.default_ordering_value'));
        }
        $menu->setIsActive($request->input('is_active'));

        // save
        $menu->save();

        $menuTranslation->setName($request->input('name'));

        $menuTranslation->setMenuId($menu->getId());
        $menuTranslation->setLanguageId(app('Language')->getId());

        $menuTranslation->save();

        LogUtil::logChanges();

        return $menu;
    }

    /**
     * @param Request $request
     * @param Menu    $menu
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveAfterAction(Request $request, Menu $menu)
    {
        return SaveAfterActionUtil::redirectAfterSaved(
            $request,
            route('admin.menu.create'),
            route('admin.menu.edit', $menu->getId())
        );
    }

    /**
     * Delete entity
     *
     * @param Menu    $menu
     * @param Request $request
     * @throws \Exception
     */
    public function delete(Menu $menu, Request $request): void
    {
        $menu->delete();

        LogUtil::logChanges();
    }

    /**
     * Get entity listing
     *
     * @param Request $request
     * @return Collection
     */
    public function getListing(Request $request): Collection
    {
        return $this->menuRepository->findListing($request)->get();
    }

    /**
     * Sort record and update parent relation
     *
     * @param array $children [['id' = int, 'children' => $children]]
     * @param int   $parent
     */
    public function sortAndUpdateParent(array $children, $parent = 0): void
    {
        if (!empty($children)) {
            foreach ($children as $position => $list) {
                $menu = Menu::find($list['id']);
                Auth::user()->can(PolicyActionEnum::UPDATE, $menu);
                if ($parent == 0) {
                    $parent = null;
                }
                $menu->setParentId($parent);
                $menu->setOrdering($position);
                $menu->save();

                LogUtil::logChanges();

                if (!empty($list['children'])) {
                    $this->sortAndUpdateParent($list['children'], $list['id']);
                }
            }
        }
    }
}