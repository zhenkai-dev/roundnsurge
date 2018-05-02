<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\BannerTranslation
 *
 * @property int $translation_id
 * @property int $banner_id
 * @property int $language_id
 * @property string|null $name
 * @property string|null $description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BannerTranslation whereBannerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BannerTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BannerTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BannerTranslation whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BannerTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BannerTranslation whereTranslationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BannerTranslation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BannerTranslation extends Model
{
    protected $primaryKey = 'translation_id';

    public $incrementing = false;

    /**
     * Get table name with static call
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'banner_translations';
    }

    /**
     * @return int
     */
    public function getTranslationId(): int
    {
        return $this->translation_id;
    }

    /**
     * @param int $translation_id
     */
    public function setTranslationId(int $translation_id): void
    {
        $this->translation_id = $translation_id;
    }

    /**
     * @return int
     */
    public function getBannerId(): int
    {
        return $this->banner_id;
    }

    /**
     * @param int $banner_id
     */
    public function setBannerId(int $banner_id): void
    {
        $this->banner_id = $banner_id;
    }

    /**
     * @return int
     */
    public function getLanguageId(): int
    {
        return $this->language_id;
    }

    /**
     * @param int $language_id
     */
    public function setLanguageId(int $language_id): void
    {
        $this->language_id = $language_id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param null|string $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
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
}
