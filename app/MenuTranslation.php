<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MenuTranslation
 *
 * @property int $translation_id
 * @property int $menu_id
 * @property int $language_id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuTranslation whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuTranslation whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuTranslation whereTranslationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuTranslation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MenuTranslation extends Model
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
        return 'menu_translations';
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
    public function getMenuId(): int
    {
        return $this->menu_id;
    }

    /**
     * @param int $menu_id
     */
    public function setMenuId(int $menu_id): void
    {
        $this->menu_id = $menu_id;
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
