<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserPermission
 *
 * @property int $id
 * @property int $user_id
 * @property string $module
 * @property bool $can_insert
 * @property bool $can_update
 * @property bool $can_delete
 * @property bool $can_view
 * @property bool $is_active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserPermission whereCanDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserPermission whereCanInsert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserPermission whereCanUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserPermission whereCanView($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserPermission whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserPermission whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserPermission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserPermission whereUserId($value)
 * @mixin \Eloquent
 */
class UserPermission extends Model
{
    protected $casts = [
        'can_insert' => 'boolean',
        'can_update' => 'boolean',
        'can_delete' => 'boolean',
        'can_view' => 'boolean',
        'is_active' => 'boolean'
    ];

    /**
     * Get table name with static call
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'user_permissions';
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
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
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
     * @return bool
     */
    public function isCanInsert(): bool
    {
        return $this->can_insert;
    }

    /**
     * @param bool $can_insert
     */
    public function setCanInsert(bool $can_insert): void
    {
        $this->can_insert = $can_insert;
    }

    /**
     * @return bool
     */
    public function isCanUpdate(): bool
    {
        return $this->can_update;
    }

    /**
     * @param bool $can_update
     */
    public function setCanUpdate(bool $can_update): void
    {
        $this->can_update = $can_update;
    }

    /**
     * @return bool
     */
    public function isCanDelete(): bool
    {
        return $this->can_delete;
    }

    /**
     * @param bool $can_delete
     */
    public function setCanDelete(bool $can_delete): void
    {
        $this->can_delete = $can_delete;
    }

    /**
     * @return bool
     */
    public function isCanView(): bool
    {
        return $this->can_view;
    }

    /**
     * @param bool $can_view
     */
    public function setCanView(bool $can_view): void
    {
        $this->can_view = $can_view;
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
}
