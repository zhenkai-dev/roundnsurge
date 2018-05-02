<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * App\Banner
 *
 * @property int                 $id
 * @property string|null         $photo
 * @property int|null            $url_id Link to friendly url table
 * @property string|null         $url External url
 * @property string|null         $target
 * @property int                 $ordering
 * @property bool                $is_active
 * @property string|null         $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Banner onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereOrdering($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner whereUrlId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Banner withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Banner withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\BannerTranslation $bannerTranslation
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Banner wherePhoto($value)
 */
class Banner extends Model
{
    use SoftDeletes;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get table name with static call
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'banners';
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return null|string
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * @param null|string $photo
     */
    public function setPhoto(?string $photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @return int|null
     */
    public function getUrlId(): ?int
    {
        return $this->url_id;
    }

    /**
     * @param int|null $url_id
     */
    public function setUrlId(?int $url_id): void
    {
        $this->url_id = $url_id;
    }

    /**
     * @return null|string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param null|string $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return null|string
     */
    public function getTarget(): ?string
    {
        return $this->target;
    }

    /**
     * @param null|string $target
     */
    public function setTarget(?string $target): void
    {
        $this->target = $target;
    }

    /**
     * @return int
     */
    public function getOrdering(): int
    {
        return $this->ordering;
    }

    /**
     * @param int $ordering
     */
    public function setOrdering(int $ordering): void
    {
        $this->ordering = $ordering;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->is_active;
    }

    /**
     * @param bool $is_active
     */
    public function setIsActive(bool $is_active): void
    {
        $this->is_active = $is_active;
    }

    /**
     * @return \Carbon\Carbon|null
     */
    public function getCreatedAt(): ?\Carbon\Carbon
    {
        return $this->created_at;
    }

    /**
     * @return \Carbon\Carbon|null
     */
    public function getUpdatedAt(): ?\Carbon\Carbon
    {
        return $this->updated_at;
    }

    /**
     * @param string $lang
     * @return HasOne
     */
    public function bannerTranslation(string $lang = ''): HasOne
    {
        if (empty($lang)) {
            $lang = app('Language')->getId();
        }

        return $this->hasOne('App\BannerTranslation', 'banner_id', 'id')
            ->where('language_id', $lang);
    }

    /**
     * Get asset with full url
     *
     * @return string
     */
    public function getPhotoFullUrl(): string
    {
        return url(Storage::url(config('storage.directory.banner') . '/' . $this->getPhoto()));
    }

    public function getPhotoThumbnailFullUrl(): string
    {
        $pathParts = pathinfo(Storage::path(
            config('storage.root') . '/' . config('storage.directory.banner') . '/' . $this->getPhoto()
        ));
        return url(Storage::url(
            config('storage.directory.banner') . '/' . $pathParts['filename'] .
            config('storage.size.banner.thumbnail.postfix') . '.' . $pathParts['extension']
        ));
    }
}
