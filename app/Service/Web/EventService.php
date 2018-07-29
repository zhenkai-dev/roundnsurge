<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 21/4/2018
 * Time: 5:05 PM
 */

namespace App\Service\Web;


use App\Repository\Web\EventRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class EventService
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Get entity listing
     *
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getListing(Request $request): LengthAwarePaginator
    {
        return $this->eventRepository->findListing($request);
    }
}