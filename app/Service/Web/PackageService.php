<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 14/5/2018
 * Time: 11:08 AM
 */

namespace App\Service\Web;


use App\Repository\Web\PackageRepository;
use Illuminate\Database\Eloquent\Collection;

class PackageService
{
    private $packageRepository;

    public function __construct(PackageRepository $packageRepository)
    {
        $this->packageRepository = $packageRepository;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAll(): Collection
    {
        return PackageRepository::findAll()->get();
    }
}