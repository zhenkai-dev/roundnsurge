<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 20/2/2018
 * Time: 11:15 PM
 */

namespace App\Service\Member;

use App\FriendlyUrl;
use App\Repository\Member\FriendlyUrlRepository;

class FriendlyUrlService
{
    private $friendlyUrlRepository;

    public function __construct(FriendlyUrlRepository $friendlyUrlRepository)
    {
        $this->friendlyUrlRepository = $friendlyUrlRepository;
    }

    /**
     * @param string $module
     * @param int    $id
     * @param string $name
     */
    public function insertOrUpdateNameByModule(string $module, int $id, string $name): void
    {
        $friendlyUrl = FriendlyUrl::where('fkid', '=', $id)
            ->where('module', '=', $module)
            ->first();

        if ($friendlyUrl === null) {
            $friendlyUrl = new FriendlyUrl();
        }

        $uniqueName = $this->generateUniqueName($friendlyUrl, $name);

        $friendlyUrl->setName($uniqueName);
        $friendlyUrl->setFkid($id);
        $friendlyUrl->setModule($module);
        $friendlyUrl->save();
    }

    /**
     * Generate unique url name
     *
     * @param FriendlyUrl $friendlyUrl
     * @param string      $name
     * @return string
     */
    public function generateUniqueName(FriendlyUrl $friendlyUrl, string $name): string
    {
        $id = '';
        if ($friendlyUrl->exists) {
            $id = $friendlyUrl->getId();
        }

        $urlName = str_slug($name);
        $urlToCheck = $urlName;

        //check from db
        $n = 0;
        while (count(FriendlyUrl::where('name', $urlToCheck)->where('id', '!=', $id)->get())) {
            $n++;
            $urlToCheck = $urlName . '-' . $n;
        }

        return $urlToCheck;
    }

    public static function getUrlList(): array
    {
        $pages = FriendlyUrlRepository::getPages()->get()->toArray();
        $news = FriendlyUrlRepository::getNews()->get()->toArray();
        return ['page' => $pages, 'news' => $news];
    }
}
