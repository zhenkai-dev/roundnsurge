<?php

namespace App\Service\Admin;

use App\Banner;
use App\BannerTranslation;
use App\Enumeration\PolicyActionEnum;
use App\Enumeration\RouteTypeEnum;
use App\FriendlyUrl;
use App\Repository\Admin\BannerRepository;
use App\Service\Admin\Util\LogUtil;
use App\Service\Admin\Util\SaveAfterActionUtil;
use App\Service\Util\FileUtil;
use App\Service\Util\ImageUtil;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BannerService
{
    private $bannerRepository;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * Request validation
     *
     * @param Banner  $banner
     * @param Request $request
     * @return mixed
     */
    public function validate(Banner $banner, Request $request): \Illuminate\Validation\Validator
    {
        if (route_type() == RouteTypeEnum::STORE) {
            return Validator::make($request->all(), [
                'name' => 'nullable|max:255',
                'photo' => 'required|image|max:' . config('filesystems.max_uploaded_size'),
                'photo_mobile' => 'required|image|max:' . config('filesystems.max_uploaded_size'),
                'url_id' => 'nullable|exists:' . FriendlyUrl::getTableName() . ',id',
                'url' => 'nullable|string',
                'target' => 'required|string',
                'is_active' => 'required|boolean'
            ]);
        } else {
            return Validator::make($request->all(), [
                'name' => 'nullable|max:255',
                'photo' => 'nullable|image|max:' . config('filesystems.max_uploaded_size'),
                'photo_mobile' => 'required|image|max:' . config('filesystems.max_uploaded_size'),
                'url_id' => 'nullable|exists:' . FriendlyUrl::getTableName() . ',id',
                'url' => 'nullable|string',
                'target' => 'required|string',
                'is_active' => 'required|boolean'
            ]);
        }
    }

    /**
     * Save entity
     *
     * @param Banner  $banner
     * @param Request $request
     * @return Banner
     */
    public function save(Banner $banner, Request $request): Banner
    {
        $isEdit = $banner->exists;

        if ($isEdit) {
            $bannerTranslation = $banner->bannerTranslation()->first();
        } else {
            $bannerTranslation = new BannerTranslation();
        }

        //upload file
        $photo = $request->file('photo');
        if ($request->hasFile('photo') && $photo->isValid()) {
            // Remove old files
            $this->removePhoto($banner);

            $filenameToStore = $this->uploadPhoto($photo);

            $banner->setPhoto($filenameToStore);
        }

        //upload file mobile
        $photo_mobile = $request->file('photo_mobile');
        if ($request->hasFile('photo_mobile') && $photo_mobile->isValid()) {
            // Remove old files
            $this->removePhotoMobile($banner);

            $filenameToStore = $this->uploadPhotoMobile($photo_mobile);

            $banner->setPhotoMobile($filenameToStore);
        }

        $banner->setUrlId($request->input('url_id'));
        $banner->setUrl($request->input('url'));
        $banner->setTarget($request->input('target'));
        if (!$isEdit) {
            $banner->setOrdering(config('app.default_ordering_value'));
        }
        $banner->setIsActive($request->input('is_active'));

        // save
        $banner->save();

        $bannerTranslation->setName($request->input('name'));
        $bannerTranslation->setDescription($request->input('description'));

        $bannerTranslation->setBannerId($banner->getId());
        $bannerTranslation->setLanguageId(app('Language')->getId());

        $bannerTranslation->save();

        LogUtil::logChanges();

        return $banner;
    }

    /**
     * @param Request $request
     * @param Banner  $banner
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveAfterAction(Request $request, Banner $banner)
    {
        return SaveAfterActionUtil::redirectAfterSaved(
            $request,
            route('admin.banner.create'),
            route('admin.banner.edit', $banner->getId())
        );
    }

    /**
     * Delete entity
     *
     * @param Banner  $banner
     * @param Request $request
     * @throws \Exception
     */
    public function delete(Banner $banner, Request $request): void
    {
        $this->removePhoto($banner);
        $banner->delete();

        LogUtil::logChanges();
    }

    /**
     * Get entity listing
     *
     * @param Request $request
     * @return Builder
     */
    public function getListing(Request $request): Builder
    {
        return $this->bannerRepository->findListing($request);
    }

    /**
     * @param array $items [['id' = int]]
     */
    public function sortable(array $items): void
    {
        if (!empty($items)) {
            foreach ($items as $position => $list) {
                $banner = Banner::find($list['id']);
                Auth::user()->can(PolicyActionEnum::UPDATE, $banner);
                $banner->setOrdering($position);
                $banner->save();

                LogUtil::logChanges();
            }
        }
    }

    /**
     * Upload photo
     *
     * @param UploadedFile $photo
     * @return string Filename to store
     */
    private function uploadPhoto(UploadedFile $photo): string
    {
        $path = config('storage.directory.banner');

        list($filename, $extension) = FileUtil::generateFilename($photo, $path);

        $filenameToStore = $filename . '.' . $extension;

        ImageUtil::resize(
            $photo,
            $path . '/' . $filenameToStore,
            config('storage.size.banner.width'),
            config('storage.size.banner.height')
        );

        ImageUtil::resizeFit(
            $photo,
            $path . '/' . $filename . config('storage.size.banner.thumbnail.postfix') . '.' . $extension,
            config('storage.size.banner.thumbnail.width'),
            config('storage.size.banner.thumbnail.height')
        );

        return $filenameToStore;
    }

    /**
     * Remove photo
     *
     * @param Banner $banner
     */
    private function removePhoto(Banner $banner): void
    {
        if ($banner->getPhoto()) {
            $path = config('storage.root') . '/' . config('storage.directory.banner');

            $pathParts = pathinfo(Storage::path($path . '/' . $banner->getPhoto()));

            $remove = array(
                $path . '/' . $banner->getPhoto(),
                $path . '/' .
                $pathParts['filename'] .
                config('storage.size.banner.thumbnail.postfix') .
                '.' . $pathParts['extension']
            );

            Storage::delete($remove);
        }
    }

    /**
     * Upload photo mobile
     *
     * @param UploadedFile $photo
     * @return string Filename to store
     */
    private function uploadPhotoMobile(UploadedFile $photo): string
    {
        $path = config('storage.directory.banner');

        list($filename, $extension) = FileUtil::generateFilename($photo, $path);

        $filenameToStore = $filename . config('storage.size.banner.mobile.postfix') . '.' . $extension;

        ImageUtil::resize(
            $photo,
            $path . '/' . $filenameToStore,
            config('storage.size.banner.mobile.width'),
            config('storage.size.banner.mobile.height')
        );

        return $filenameToStore;
    }

    /**
     * Remove photo mobile
     *
     * @param Banner $banner
     */
    private function removePhotoMobile(Banner $banner): void
    {
        if ($banner->getPhoto()) {
            $path = config('storage.root') . '/' . config('storage.directory.banner');

            $pathParts = pathinfo(Storage::path($path . '/' . $banner->getPhoto()));

            $remove = array(
                $path . '/' . $banner->getPhotoMobile(),
                $path . '/' .
                $pathParts['filename'] .
                config('storage.size.banner.mobile.postfix') .
                '.' . $pathParts['extension']
            );

            Storage::delete($remove);
        }
    }
}
