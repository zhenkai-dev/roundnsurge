<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\NewsTranslation
 *
 * @property int $translation_id
 * @property int $news_id
 * @property int $language_id
 * @property string $name
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_keywords
 * @property string|null $meta_description
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsTranslation whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsTranslation whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsTranslation whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsTranslation whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsTranslation whereNewsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsTranslation whereTranslationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsTranslation whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $short_intro
 * @method static \Illuminate\Database\Eloquent\Builder|\App\NewsTranslation whereShortIntro($value)
 */
class NewsTranslation extends Model
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
        return 'news_translations';
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
    public function getNewsId(): int
    {
        return $this->news_id;
    }

    /**
     * @param int $news_id
     */
    public function setNewsId(int $news_id): void
    {
        $this->news_id = $news_id;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getShortIntro(): ?string
    {
        return $this->short_intro;
    }

    /**
     * @param null|string $short_intro
     */
    public function setShortIntro(?string $short_intro): void
    {
        $this->short_intro = $short_intro;
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
     * @return null|string
     */
    public function getMetaTitle(): ?string
    {
        return $this->meta_title;
    }

    /**
     * @param null|string $meta_title
     */
    public function setMetaTitle(?string $meta_title): void
    {
        $this->meta_title = $meta_title;
    }

    /**
     * @return null|string
     */
    public function getMetaKeywords(): ?string
    {
        return $this->meta_keywords;
    }

    /**
     * @param null|string $meta_keywords
     */
    public function setMetaKeywords(?string $meta_keywords): void
    {
        $this->meta_keywords = $meta_keywords;
    }

    /**
     * @return null|string
     */
    public function getMetaDescription(): ?string
    {
        return $this->meta_description;
    }

    /**
     * @param null|string $meta_description
     */
    public function setMetaDescription(?string $meta_description): void
    {
        $this->meta_description = $meta_description;
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
