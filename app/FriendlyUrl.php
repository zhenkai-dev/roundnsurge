<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * App\FriendlyUrl
 *
 * @property int                 $id
 * @property int                 $fkid
 * @property string              $module
 * @property string              $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FriendlyUrl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FriendlyUrl whereFkid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FriendlyUrl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FriendlyUrl whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FriendlyUrl whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FriendlyUrl whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $friendlyUrlOwned
 */
class FriendlyUrl extends Model
{
    /**
     * Get table name with static call
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'friendly_urls';
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
     * @return int
     */
    public function getFkid(): int
    {
        return $this->fkid;
    }

    /**
     * @param int $fkid
     */
    public function setFkid(int $fkid): void
    {
        $this->fkid = $fkid;
    }

    /**
     * @return string
     */
    public function getModule(): string
    {
        return $this->module;
    }

    /**
     * @param string $module
     */
    public function setModule(string $module): void
    {
        $this->module = $module;
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

    /**
     * Get all the owning friendlyUrl models
     *
     * @return MorphTo
     */
    public function friendlyUrlOwned(): MorphTo
    {
        return $this->morphTo('name', 'module', 'fkid');
    }
}
