<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;


/**
 * App\News
 *
 * @property int $id
 * @property \Carbon\Carbon $post_date
 * @property string|null $photo
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\News onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News wherePostDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\News withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\News withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\FriendlyUrl[] $friendlyUrl
 * @property-read \App\NewsTranslation $newsTranslation
 */
class News extends Model
{
    use SoftDeletes;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $dates = [
        'post_date'
    ];

    /**
     * Get table name with static call
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'news';
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
     * @return Carbon
     */
    public function getPostDate(): Carbon
    {
        return $this->post_date;
    }

    /**
     * @param Carbon $post_date
     */
    public function setPostDate(Carbon $post_date): void
    {
        $this->post_date = $post_date;
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
    public function newsTranslation(string $lang = ''): HasOne
    {
        if (empty($lang)) {
            $lang = app('Language')->getId();
        }

        return $this->hasOne('App\NewsTranslation', 'news_id', 'id')
            ->where('language_id', $lang);
    }

    /**
     * Get asset with full url
     *
     * @return string
     */
    public function getPhotoFullUrl(): string
    {
        return url(Storage::url(config('storage.directory.news') . '/' . $this->getPhoto()));
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
