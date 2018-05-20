<?php

namespace App\Http\Controllers\Member;

use App\Enumeration\PolicyActionEnum;
use App\FriendlyUrl;
use App\Http\Controllers\Controller;
use App\Course;
use App\CourseTranslation;
use App\Service\Member\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private $courseService;

    /**
     * Create a new controller instance.
     *
     * @param CourseService $courseService
     */
    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
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
        $this->authorize(PolicyActionEnum::INDEX, Course::class);

        $title = trans_choice('entity.course', 2);
        $courses = $this->courseService->getListing($request);

        return view('member.course.list', compact('title', 'courses'));
    }

    /**
     * Display the specified resource.
     * @param Course $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Course $course)
    {
        $this->authorize(PolicyActionEnum::VIEW, $course);

        $course->increment('total_view');

        /* @var CourseTranslation $courseTranslation */
        $courseTranslation = $course->courseTranslation(app('Language')->getId())->first();

        $title = $courseTranslation->getName();

        return view('member.course.show', compact('title', 'course', 'courseTranslation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize(PolicyActionEnum::CREATE, Course::class);

        $course = new Course();
        $title = __('form.add_new_record');
        return view('member.course.form', compact('title', 'course'));
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
        $this->authorize(PolicyActionEnum::CREATE, Course::class);

        $course = new Course();

        // validation
        $validator = $this->courseService->validate($course, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $course = $this->courseService->save($course, $request);

        return $this->courseService->saveAfterAction($request, $course)
            ->with('status', __('message.record_created'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Course $course
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Course $course)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $course);

        /* @var CourseTranslation $courseTranslation */
        $courseTranslation = $course->courseTranslation(app('Language')->getId())->first();

        $title = 'Edit ' . $courseTranslation->getName();
        return view('member.course.form', compact('title', 'course', 'courseTranslation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Course    $course
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Course $course, Request $request)
    {
        $this->authorize(PolicyActionEnum::UPDATE, $course);

        // validation
        $validator = $this->courseService->validate($course, $request);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $course = $this->courseService->save($course, $request);

        return $this->courseService->saveAfterAction($request, $course)
            ->with('status', __('message.record_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Course    $course
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Course $course, Request $request)
    {
        $this->authorize(PolicyActionEnum::DELETE, $course);

        $this->courseService->delete($course, $request);

        return back()->with('status', __('message.record_deleted'));
    }
}
