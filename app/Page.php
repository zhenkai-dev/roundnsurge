<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;

/**
 * App\Page
 *
 * @property int                       $id
 * @property string|null               $photo
 * @property bool                      $is_module
 * @property bool                      $no_index
 * @property bool                      $is_persist Indicate if record is deletable.
 * @property bool                      $is_active
 * @property string|null               $deleted_at
 * @property \Carbon\Carbon|null       $created_at
 * @property \Carbon\Carbon|null       $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Page onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereIsModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereIsPersist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereNoIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Page withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Page withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\PageTranslation $pageTranslations
 * @property-read \App\PageTranslation $pageTranslation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\FriendlyUrl[] $friendlyUrl
 */
class Page extends Model
{
    use SoftDeletes;

    protected $casts = [
        'is_module' => 'boolean',
        'no_index' => 'boolean',
        'is_persist' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get table name with static call
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'pages';
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
     * @return bool
     */
    public function isModule(): bool
    {
        return $this->is_module;
    }

    /**
     * @param bool $is_module
     */
    public function setIsModule(bool $is_module): void
    {
        $this->is_module = $is_module;
    }

    /**
     * @return bool
     */
    public function isNoIndex(): bool
    {
        return $this->no_index;
    }

    /**
     * @param bool $no_index
     */
    public function setNoIndex(bool $no_index): void
    {
        $this->no_index = $no_index;
    }

    /**
     * @return bool
     */
    public function isPersist(): bool
    {
        return $this->is_persist;
    }

    /**
     * @param bool $is_persist
     */
    public function setIsPersist(bool $is_persist): void
    {
        $this->is_persist = $is_persist;
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
    public function pageTranslation(string $lang = ''): HasOne
    {
        if (empty($lang)) {
            $lang = app('Language')->getId();
        }

        return $this->hasOne('App\PageTranslation', 'page_id', 'id')
            ->where('language_id', $lang);
    }

    /**
     * Get asset with full url
     *
     * @return string
     */
    public function getPhotoFullUrl(): string
    {
        return url(Storage::url(config('storage.directory.page') . '/' . $this->getPhoto()));
    }

    /**
     * Get friendly url
     *
     * @return MorphMany
     */
    public function friendlyUrl(): MorphMany
    {
        return $this->morphMany('App\FriendlyUrl', 'name', 'module', 'fkid');
    }
}
