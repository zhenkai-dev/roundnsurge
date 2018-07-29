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
use App\Event;
use App\Service\Web\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    private $eventService;

    /**
     * Create a new controller instance.
     *
     * @param EventService $eventService
     */
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    public function index(Request $request)
    {
        $eventList = $this->eventService->getListing($request);
        return view('web.pages.event.list', compact('eventList'));
    }
}
