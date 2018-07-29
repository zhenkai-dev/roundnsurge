<?php

namespace App\Service\Admin;

use App\Enumeration\RouteTypeEnum;
use App\Event;
use App\EventTranslation;
use App\Repository\Admin\EventRepository;
use App\Service\Admin\Util\LogUtil;
use App\Service\Admin\Util\SaveAfterActionUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class EventService
{
    private $eventRepository;

    private $friendlyUrlService;

    public function __construct(EventRepository $eventRepository, FriendlyUrlService $friendlyUrlService)
    {
        $this->eventRepository = $eventRepository;
        $this->friendlyUrlService = $friendlyUrlService;
    }

    /**
     * Request validation
     *
     * @param Event   $event
     * @param Request $request
     * @return mixed
     */
    public function validate(Event $event, Request $request): \Illuminate\Validation\Validator
    {
        if (route_type() == RouteTypeEnum::STORE) {
            return Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'event_start_at' => 'required|date|date_format:"m/d/Y h:i A"',
                'event_end_at' => 'required|date|date_format:"m/d/Y h:i A"',
                'rsvp_link' => 'required|string',
                'is_active' => 'required|boolean'
            ]);
        } else {
            return Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'event_start_at' => 'required|date|date_format:"m/d/Y h:i A"',
                'event_end_at' => 'required|date|date_format:"m/d/Y h:i A"',
                'rsvp_link' => 'required|string',
                'is_active' => 'required|boolean'
            ]);
        }
    }

    /**
     * Save entity
     *
     * @param Event   $event
     * @param Request $request
     * @return Event
     */
    public function save(Event $event, Request $request): Event
    {
        $isEdit = $event->exists;

        if ($isEdit) {
            $eventTranslation = $event->eventTranslation()->first();
        } else {
            $eventTranslation = new EventTranslation();
        }

        $event->setRsvpLink($request->input('rsvp_link'));
        $event->setEventStartAt(new Carbon($request->input('event_start_at')));
        $event->setEventEndAt(new Carbon($request->input('event_end_at')));
        $event->setIsActive($request->input('is_active'));

        // save
        $event->save();

        $eventTranslation->setName($request->input('name'));

        $eventTranslation->setEventId($event->getId());
        $eventTranslation->setLanguageId(app('Language')->getId());

        $eventTranslation->save();

        /*if ($isEdit) {
            $this->friendlyUrlService->insertOrUpdateNameByModule(
                get_class($event),
                $event->getId(),
                $request->input('url_name')
            );
        } else {
            $this->friendlyUrlService->insertOrUpdateNameByModule(
                get_class($event),
                $event->getId(),
                $request->input('name')
            );
        }*/

        LogUtil::logChanges();

        return $event;
    }

    /**
     * @param Request $request
     * @param Event   $event
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveAfterAction(Request $request, Event $event)
    {
        return SaveAfterActionUtil::redirectAfterSaved(
            $request,
            route('admin.event.create'),
            route('admin.event.edit', $event->getId())
        );
    }

    /**
     * Delete entity
     *
     * @param Event   $event
     * @param Request $request
     * @throws \Exception
     */
    public function delete(Event $event, Request $request): void
    {
        $event->delete();

        LogUtil::logChanges();
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