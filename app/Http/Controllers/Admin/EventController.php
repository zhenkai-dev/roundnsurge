<?php

namespace App\Http\Controllers\Admin;

use App\Enumeration\PolicyActionEnum;
use App\Event;
use App\EventTranslation;
use App\FriendlyUrl;
use App\Http\Controllers\Controller;
use App\Service\Admin\EventService;
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

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize(PolicyActionEnum::INDEX, Event::class);

        $title = trans_choice('entity.event', 2);
        $events = $this->eventService->getListing($request);

        return view('admin.event.list', compact('title', 'events'));
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize(PolicyActionEnum::CREATE, Event::class);

        $event = new Event();
        $title = __('form.add_new_record');
        return view('admin.event.form', compact('title', 'event'));
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
        $this->authorize(PolicyActionEnum::CREATE, Event::class);

        $event = new Event();

        // validation
        $validator = $this->eventService->validate($event, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $event = $this->eventService->save($event, $request);

        return $this->eventService->saveAfterAction($request, $event)
            ->with('status', __('message.record_created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Event $event
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Event $event)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $event);

        /* @var EventTranslation $eventTranslation */
        $eventTranslation = $event->eventTranslation(app('Language')->getId())->first();

        /* @var FriendlyUrl $friendlyUrl */
        // $friendlyUrl = $event->friendlyUrl()->first();

        $title = 'Edit ' . $eventTranslation->getName();
        return view('admin.event.form', compact('title', 'event', 'eventTranslation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Event   $event
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Event $event, Request $request)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $event);

        // validation
        $validator = $this->eventService->validate($event, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $event = $this->eventService->save($event, $request);

        return $this->eventService->saveAfterAction($request, $event)
            ->with('status', __('message.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Event   $event
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Event $event, Request $request)
    {
        $this->authorize(PolicyActionEnum::DELETE, $event);

        $this->eventService->delete($event, $request);

        return back()->with('status', __('message.record_deleted'));
    }
}
