<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Menu
 *
 * @property int                 $id
 * @property int|null            $parent_id
 * @property int|null            $url_id Link to page table
 * @property string|null         $url External url
 * @property string|null         $target
 * @property int                 $ordering
 * @property bool                $is_active
 * @property string|null         $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Menu onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereOrdering($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu whereUrlId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Menu withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Menu withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\MenuTranslation $menuTranslation
 */
class Menu extends Model
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
        return 'menus';
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
     * @return int|null
     */
    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    /**
     * @param int|null $parent_id
     */
    public function setParentId(?int $parent_id): void
    {
        $this->parent_id = $parent_id;
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
     * @return int
     */
    public function isActive(): int
    {
        return $this->is_active;
    }

    /**
     * @param int $is_active
     */
    public function setIsActive(int $is_active): void
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
    public function menuTranslation(string $lang = ''): HasOne
    {
        if (empty($lang)) {
            $lang = app('Language')->getId();
        }

        return $this->hasOne('App\MenuTranslation', 'menu_id', 'id')
            ->where('language_id', $lang);
    }
}
