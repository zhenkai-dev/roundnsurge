<?php

namespace App\Service\Member;

use App\Enumeration\RouteTypeEnum;
use App\FriendlyUrl;
use App\Course;
use App\CourseTranslation;
use App\Package;
use App\Repository\Member\CourseRepository;
use App\Service\Member\Util\LogUtil;
use App\Service\Member\Util\SaveAfterActionUtil;
use App\Service\Util\FileUtil;
use App\Service\Util\ImageUtil;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class CourseService
{
    private $courseRepository;

    private $friendlyUrlService;

    public function __construct(CourseRepository $courseRepository, FriendlyUrlService $friendlyUrlService)
    {
        $this->courseRepository = $courseRepository;
        $this->friendlyUrlService = $friendlyUrlService;
    }

    /**
     * Request validation
     *
     * @param Course    $course
     * @param Request $request
     * @return mixed
     */
    public function validate(Course $course, Request $request): \Illuminate\Validation\Validator
    {
        if (route_type() == RouteTypeEnum::STORE) {
            return Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'embed_video' => 'required|string',
                'description' => 'nullable|string',
                'packages' => 'required|array',
                'packages.*' => 'required|integer|exists:' . Package::getTableName() . ',id',
                'is_active' => 'required|boolean'
            ]);
        } else {
            return Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'embed_video' => 'required|string',
                'description' => 'nullable|string',
                'packages' => 'required|array',
                'packages.*' => 'required|integer|exists:' . Package::getTableName() . ',id',
                'is_active' => 'required|boolean'
            ]);
        }
    }

    /**
     * Save entity
     *
     * @param Course    $course
     * @param Request $request
     * @return Course
     */
    public function save(Course $course, Request $request): Course
    {
        $isEdit = $course->exists;

        if ($isEdit) {
            $courseTranslation = $course->courseTranslation()->first();
        } else {
            $courseTranslation = new CourseTranslation();
            $course->setTotalView(0);
        }

        $course->setEmbedVideo($request->input('embed_video'));
        $course->setIsActive($request->input('is_active'));

        // save
        $course->save();

        $course->packages()->sync($request->input('packages'));

        $courseTranslation->setName($request->input('name'));
        $courseTranslation->setDescription($request->input('description'));

        $courseTranslation->setCourseId($course->getId());
        $courseTranslation->setLanguageId(app('Language')->getId());

        $courseTranslation->save();

        LogUtil::logChanges();

        return $course;
    }

    /**
     * @param Request $request
     * @param Course    $course
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveAfterAction(Request $request, Course $course)
    {
        return SaveAfterActionUtil::redirectAfterSaved(
            $request,
            route('admin.course.create'),
            route('admin.course.edit', $course->getId())
        );
    }

    /**
     * Delete entity
     *
     * @param Course    $course
     * @param Request $request
     * @throws \Exception
     */
    public function delete(Course $course, Request $request): void
    {
        $course->delete();

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
        return $this->courseRepository->findListing($request);
    }
}