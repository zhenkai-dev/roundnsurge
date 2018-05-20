<?php

namespace App\Service\Admin;

use App\Enumeration\RouteTypeEnum;
use App\FriendlyUrl;
use App\News;
use App\NewsTranslation;
use App\Repository\Admin\NewsRepository;
use App\Service\Admin\Util\LogUtil;
use App\Service\Admin\Util\SaveAfterActionUtil;
use App\Service\Util\FileUtil;
use App\Service\Util\ImageUtil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class NewsService
{
    private $newsRepository;

    private $friendlyUrlService;

    public function __construct(NewsRepository $newsRepository, FriendlyUrlService $friendlyUrlService)
    {
        $this->newsRepository = $newsRepository;
        $this->friendlyUrlService = $friendlyUrlService;
    }

    /**
     * Request validation
     *
     * @param News    $news
     * @param Request $request
     * @return mixed
     */
    public function validate(News $news, Request $request): \Illuminate\Validation\Validator
    {
        if (route_type() == RouteTypeEnum::STORE) {
            return Validator::make($request->all(), [
                'name' => 'required|max:255',
                'post_date' => 'required|date|date_format:"m/d/Y"',
                'photo' => 'nullable|image|max:' . config('filesystems.max_uploaded_size'),
                'is_active' => 'required|boolean'
            ]);
        } else {
            return Validator::make($request->all(), [
                'name' => 'required|max:255',
                'photo' => 'nullable|image|max:' . config('filesystems.max_uploaded_size'),
                'is_active' => 'required|boolean'
            ]);
        }
    }

    /**
     * Save entity
     *
     * @param News    $news
     * @param Request $request
     * @return News
     */
    public function save(News $news, Request $request): News
    {
        $isEdit = $news->exists;

        if ($isEdit) {
            $newsTranslation = $news->newsTranslation()->first();
        } else {
            $newsTranslation = new NewsTranslation();
        }

        //upload file
        $photo = $request->file('photo');
        if ($request->hasFile('photo') && $photo->isValid()) {
            // Remove old files
            $this->removePhoto($news);

            $filenameToStore = $this->uploadPhoto($photo);

            $news->setPhoto($filenameToStore);
        }

        //remove file if checked
        if (!empty($request->input('photo_remove')) && $request->input('photo_remove') == 1) {
            $this->removePhoto($news);
            $news->setPhoto('');
        }

        $news->setPostDate(new Carbon($request->input('post_date')));
        $news->setIsActive($request->input('is_active'));

        // save
        $news->save();

        $newsTranslation->setName($request->input('name'));
        $newsTranslation->setShortIntro($request->input('short_intro'));
        $newsTranslation->setDescription($request->input('description'));
        $newsTranslation->setMetaTitle($request->input('meta_title'));
        $newsTranslation->setMetaKeywords($request->input('meta_keywords'));
        $newsTranslation->setMetaDescription($request->input('meta_description'));

        $newsTranslation->setNewsId($news->getId());
        $newsTranslation->setLanguageId(app('Language')->getId());

        $newsTranslation->save();

        if ($isEdit) {
            $this->friendlyUrlService->insertOrUpdateNameByModule(
                get_class($news),
                $news->getId(),
                $request->input('url_name')
            );
        } else {
            $this->friendlyUrlService->insertOrUpdateNameByModule(
                get_class($news),
                $news->getId(),
                $request->input('name')
            );
        }

        LogUtil::logChanges();

        return $news;
    }

    /**
     * @param Request $request
     * @param News    $news
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveAfterAction(Request $request, News $news)
    {
        return SaveAfterActionUtil::redirectAfterSaved(
            $request,
            route('admin.news.create'),
            route('admin.news.edit', $news->getId())
        );
    }

    /**
     * Delete entity
     *
     * @param News    $news
     * @param Request $request
     * @throws \Exception
     */
    public function delete(News $news, Request $request): void
    {
        /* @var FriendlyUrl $friendlyUrl */
        $friendlyUrl = $news->friendlyUrl()->first();

        $this->friendlyUrlService->insertOrUpdateNameByModule(
            get_class($news),
            $news->getId(),
            $friendlyUrl->getName() . time()
        );

        $this->removePhoto($news);

        $news->save();

        $news->delete();

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
        return $this->newsRepository->findListing($request);
    }

    /**
     * Upload photo
     *
     * @param UploadedFile $photo
     * @return string Filename to store
     */
    private function uploadPhoto(UploadedFile $photo): string
    {
        $path = config('storage.directory.news');

        list($filename, $extension) = FileUtil::generateFilename($photo, $path);

        $filenameToStore = $filename . '.' . $extension;

        ImageUtil::resize(
            $photo,
            $path . '/' . $filenameToStore,
            config('storage.size.news.width'),
            config('storage.size.news.height')
        );

        return $filenameToStore;
    }

    /**
     * Remove photo
     *
     * @param News $news
     */
    private function removePhoto(News $news): void
    {
        if ($news->getPhoto()) {
            $path = 'public/news';

            $remove = array(
                $path . '/' . $news->getPhoto(),
            );
            \Illuminate\Support\Facades\Storage::delete($remove);
        }
    }
}