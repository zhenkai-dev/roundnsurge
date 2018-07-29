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

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
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