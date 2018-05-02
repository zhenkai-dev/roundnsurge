<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 20/2/2018
 * Time: 11:08 PM
 */

namespace App\Service\Util;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;

class ImageUtil
{
    /**
     * @param UploadedFile $photo
     * @param string       $fullNameWithPath
     * @param int          $width
     * @param int          $height
     */
    public static function resize(UploadedFile $photo, string $fullNameWithPath, int $width, int $height): void
    {
        $image = Image::make($photo);
        $image->resize(
            $width,
            $height,
            function (Constraint $constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            }
        )->encode();
        Storage::put(config('storage.root') . '/' . $fullNameWithPath, $image->getEncoded());
    }

    /**
     * @param UploadedFile $photo
     * @param string       $fullNameWithPath
     * @param int          $width
     * @param int          $height
     */
    public static function resizeFit(UploadedFile $photo, string $fullNameWithPath, int $width, int $height): void
    {
        $image = Image::make($photo);
        $image->fit(
            $width,
            $height,
            function (Constraint $constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            }
        )->encode();
        Storage::put(config('storage.root') . '/' . $fullNameWithPath, $image->getEncoded());
    }
}
