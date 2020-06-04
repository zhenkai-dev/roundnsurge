<?php

namespace App\Service\Admin;

use App\Enumeration\RouteTypeEnum;
use App\FriendlyUrl;
use App\Package;
use App\PackageTranslation;
use App\Repository\Admin\PackageRepository;
use App\Service\Admin\Util\LogUtil;
use App\Service\Admin\Util\SaveAfterActionUtil;
use App\Service\Util\FileUtil;
use App\Service\Util\ImageUtil;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;

class PackageService
{
    private $packageRepository;

    private $friendlyUrlService;

    public function __construct(PackageRepository $packageRepository, FriendlyUrlService $friendlyUrlService)
    {
        $this->packageRepository = $packageRepository;
        $this->friendlyUrlService = $friendlyUrlService;
    }

    /**
     * Request validation
     *
     * @param Package    $package
     * @param Request $request
     * @return mixed
     */
    public function validate(Package $package, Request $request): \Illuminate\Validation\Validator
    {
        if (route_type() == RouteTypeEnum::STORE) {
            return Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'description' => 'nullable|string'
            ]);
        } else {
            return Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'description' => 'nullable|string'
            ]);
        }
    }

    /**
     * Save entity
     *
     * @param Package    $package
     * @param Request $request
     * @return Package
     */
    public function save(Package $package, Request $request): Package
    {
        $isEdit = $package->exists;

        if ($isEdit) {
            $packageTranslation = $package->packageTranslation()->first();
        } else {
            $packageTranslation = new PackageTranslation();
        }

        $package->setPrice($request->input('price'));
        $package->setAllowedPackageId($request->input('allowed_package_id'));

        // save
        $package->save();

        $packageTranslation->setName($request->input('name'));
        $packageTranslation->setDescription($request->input('description'));

        $packageTranslation->setPackageId($package->getId());
        $packageTranslation->setLanguageId(app('Language')->getId());

        $packageTranslation->save();

        LogUtil::logChanges();

        return $package;
    }

    /**
     * @param Request $request
     * @param Package    $package
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function saveAfterAction(Request $request, Package $package)
    {
        return SaveAfterActionUtil::redirectAfterSaved(
            $request,
            route('admin.package.create'),
            route('admin.package.edit', $package->getId())
        );
    }

    /**
     * Delete entity
     *
     * @param Package    $package
     * @param Request $request
     * @throws \Exception
     */
    public function delete(Package $package, Request $request): void
    {
        /* @var FriendlyUrl $friendlyUrl */
        $friendlyUrl = $package->friendlyUrl()->first();

        $this->friendlyUrlService->insertOrUpdateNameByModule(
            get_class($package),
            $package->getId(),
            $friendlyUrl->getName() . time()
        );

        $this->removePhoto($package);

        $package->save();

        $package->delete();

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
        return $this->packageRepository->findListing($request);
    }

    /**
     * Upload photo
     *
     * @param UploadedFile $photo
     * @return string Filename to store
     */
    private function uploadPhoto(UploadedFile $photo): string
    {
        $path = config('storage.directory.package');

        list($filename, $extension) = FileUtil::generateFilename($photo, $path);

        $filenameToStore = $filename . '.' . $extension;

        ImageUtil::resize(
            $photo,
            $path . '/' . $filenameToStore,
            config('storage.size.package.width'),
            config('storage.size.package.height')
        );

        return $filenameToStore;
    }

    /**
     * Remove photo
     *
     * @param Package $package
     */
    private function removePhoto(Package $package): void
    {
        if ($package->getPhoto()) {
            $path = 'public/package';

            $remove = array(
                $path . '/' . $package->getPhoto(),
            );
            \Illuminate\Support\Facades\Storage::delete($remove);
        }
    }
}