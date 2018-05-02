<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 5/4/2018
 * Time: 8:29 AM
 */

namespace App\Service\Web;

use App\Repository\Web\MenuRepository;
use Illuminate\Database\Eloquent\Collection;

class MenuService
{
    private $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAll(): Collection
    {
        return MenuRepository::findAll()->get();
    }
}