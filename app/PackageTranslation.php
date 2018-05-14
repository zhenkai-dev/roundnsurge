<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PackageTranslation
 *
 * @property int $translation_id
 * @property int $package_id
 * @property int $language_id
 * @property string $name
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PackageTranslation whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PackageTranslation whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PackageTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PackageTranslation wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PackageTranslation whereTranslationId($value)
 * @mixin \Eloquent
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PackageTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PackageTranslation whereUpdatedAt($value)
 */
class PackageTranslation extends Model
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
        return 'package_translations';
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
    public function getPackageId(): int
    {
        return $this->package_id;
    }

    /**
     * @param int $package_id
     */
    public function setPackageId(int $package_id): void
    {
        $this->package_id = $package_id;
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
