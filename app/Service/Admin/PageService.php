<?php

namespace App\Service\Admin;

use App\Enumeration\RouteTypeEnum;
use App\FriendlyUrl;
use App\Page;
use App\PageTranslation;
use App\Repository\Admin\PageRepository;
use App\Service\Admin\Util\LogUtil;
use App\Service\Admin\Util\SaveAfterActionUtil;
use App\Service\Util\FileUtil;
use App\Service\Util\ImageUtil;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class PageService
{
    private $pageRepository;

    private $friendlyUrlService;

    public function __construct(PageRepository $pageRepository, FriendlyUrlService $friendlyUrlService)
    {
        $this->pageRepository = $pageRepository;
        $this->friendlyUrlService = $friendlyUrlService;
    }

    /**
     * Request validation
     *
     * @param Page    $page
     * @param Request $request
     * @return mixed
     */
    public function validate(Page $page, Request $request): \Illuminate\Validation\Validator
    {
        if (route_type() == RouteTypeEnum::STORE) {
            return Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'photo' => 'nullable|image|max:' . config('filesystems.max_uploaded_size'),
                'is_active' => 'required|boolean'
            ]);
        } else {
            return Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'url_name' => (!$page->isModule() && $page->getId() > 1 ? 'required|' : '') . 'string|max:255',
                'photo' => 'nullable|image|max:' . config('filesystems.max_uploaded_size'),
                'is_active' => 'required|boolean'
            ]);
        }
    }

    /**
     * Save entity
     *
     * @param Page    $page
     * @param Request $request
     * @return Page
     */
    public function save(Page $page, Request $request): Page
    {
        $isEdit = $page->exists;

        if ($isEdit) {
            $pageTranslation = $page->pageTranslation()->first();
        } else {
            $pageTranslation = new PageTranslation();
        }

        //upload file
        $photo = $request->file('photo');
        if ($request->hasFile('photo') && $photo->isValid()) {
            // Remove old files
            $this->removePhoto($page);

            $filenameToStore = $this->uploadPhoto($photo);

            $page->setPhoto($filenameToStore);
        }

        //remove file if checked
        if (!empty($request->input('photo_remove')) && $request->input('photo_remove') == 1) {
            $this->removePhoto($page);
            $page->setPhoto('');
        }

        if (!$isEdit) {
            $page->setIsModule(false);
            $page->setNoIndex(false);
            $page->setIsPersist(false);
        }
        $page->setIsActive($request->input('is_active'));

        // save
        $page->save();

        $pageTranslation->setName($request->input('name'));
        $pageTranslation->setDescription($request->input('description'));
        $pageTranslation->setMetaTitle($request->input('meta_title'));
        $pageTranslation->setMetaKeywords($request->input('meta_keywords'));
        $pageTranslation->setMetaDescription($request->input('meta_description'));

        $pageTranslation->setPageId($page->getId());
        $pageTranslation->setLanguageId(app('Language')->getId());

        $pageTranslation->save();

        if (!$page->isModule() && $page->getId() > 1) {
            if ($isEdit) {
                $this->friendlyUrlService->insertOrUpdateNameByModule(
                    get_class($page),
                    $page->getId(),
                    $request->input('url_name')
                );
            } else {
                $this->friendlyUrlService->insertOrUpdateNameByModule(
                    get_class($page),
                    $page->getId(),
                    $request->input('name')
                );
            }
        }

        LogUtil::logChanges();

        return $page;
    }

    /**
     * @param Request $request
     * @param Page    $page
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveAfterAction(Request $request, Page $page)
    {
        return SaveAfterActionUtil::redirectAfterSaved(
            $request,
            route('admin.page.create'),
            route('admin.page.edit', $page->getId())
        );
    }

    /**
     * Delete entity
     *
     * @param Page    $page
     * @param Request $request
     * @throws \Exception
     */
    public function delete(Page $page, Request $request): void
    {
        /* @var FriendlyUrl $friendlyUrl */
        $friendlyUrl = $page->friendlyUrl()->first();

        $this->friendlyUrlService->insertOrUpdateNameByModule(
            get_class($page),
            $page->getId(),
            $friendlyUrl->getName() . time()
        );

        $this->removePhoto($page);

        $page->save();

        $page->delete();

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
        return $this->pageRepository->findListing($request);
    }

    /**
     * Upload photo
     *
     * @param UploadedFile $photo
     * @return string Filename to store
     */
    private function uploadPhoto(UploadedFile $photo): string
    {
        $path = config('storage.directory.page');

        list($filename, $extension) = FileUtil::generateFilename($photo, $path);

        $filenameToStore = $filename . '.' . $extension;

        ImageUtil::resize(
            $photo,
            $path . '/' . $filenameToStore,
            config('storage.size.page.width'),
            config('storage.size.page.height')
        );

        return $filenameToStore;
    }

    /**
     * Remove photo
     *
     * @param Page $page
     */
    private function removePhoto(Page $page): void
    {
        if ($page->getPhoto()) {
            $path = 'public/page';

            $remove = array(
                $path . '/' . $page->getPhoto(),
            );
            \Illuminate\Support\Facades\Storage::delete($remove);
        }
    }
}