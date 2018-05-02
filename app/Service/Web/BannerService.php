<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 14/4/2018
 * Time: 7:39 PM
 */

namespace App\Service\Web;

use App\Repository\Web\BannerRepository;
use Illuminate\Database\Eloquent\Collection;

class BannerService
{
    private $bannerRepository;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public static function getAll(): Collection
    {
        return BannerRepository::findAll()->get();
    }
}