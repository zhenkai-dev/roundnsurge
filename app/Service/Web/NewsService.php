<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 21/4/2018
 * Time: 5:05 PM
 */

namespace App\Service\Web;


use App\Repository\Web\NewsRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsService
{
    private $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * Get entity listing
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getListing(Request $request): LengthAwarePaginator
    {
        return $this->newsRepository->findListing($request);
    }
}