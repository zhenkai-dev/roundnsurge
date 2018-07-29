<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * \App\Course
 *
 * @property int $id
 * @property string $embed_video
 * @property int $total_view
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Package[] $packages
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereEmbedVideo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereTotalView($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Course whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\CourseTranslation $courseTranslation
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Course onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Course withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Course withoutTrashed()
 */
class Course extends Model
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
        return 'courses';
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
     * @return string
     */
    public function getEmbedVideo(): string
    {
        return $this->embed_video;
    }

    /**
     * @param string $embed_video
     */
    public function setEmbedVideo(string $embed_video): void
    {
        $this->embed_video = $embed_video;
    }

    /**
     * @return int
     */
    public function getTotalView(): int
    {
        return $this->total_view;
    }

    /**
     * @param int $total_view
     */
    public function setTotalView(int $total_view): void
    {
        $this->total_view = $total_view;
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
     * @return BelongsToMany
     */
    public function packages(): BelongsToMany
    {
        return $this->belongsToMany('App\Package', 'course_packages');
    }

    /**
     * @param string $lang
     * @return HasOne
     */
    public function courseTranslation(string $lang = ''): HasOne
    {
        if (empty($lang)) {
            $lang = app('Language')->getId();
        }

        return $this->hasOne('App\CourseTranslation', 'course_id', 'id')
            ->where('language_id', $lang);
    }
}
