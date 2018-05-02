<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 20/2/2018
 * Time: 6:21 PM
 */

namespace App\Service\Util;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUtil
{
    /**
     * Generate file name by str_slug the original file name, and attach -n prefix and the end of duplicated found.
     *
     * @param UploadedFile $file upload file
     * @param string       $path file path
     * @return array with generated file name (without extension) and extension
     */
    public static function generateFilename(UploadedFile $file, string $path): array
    {
        $extension = $file->extension();
        $originalName = str_slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), '-');
        $filenameToCheck = $originalName;

        $n = 0;
        while ($exists = Storage::disk('local')->exists(
            config('storage.root') . '/' . $path . '/' . $filenameToCheck . '.' . $extension
        )) {
            $n++;
            $filenameToCheck = $originalName . '-' . $n;
        }
        return [$filenameToCheck, $extension];
    }
}
