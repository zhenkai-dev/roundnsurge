<?php

namespace App;

use App\Enumeration\RoleEnum;
use App\Enumeration\RolePermissionEnum;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string|null $photo
 * @property string|null $last_login_ip
 * @property string|null $last_login_at
 * @property string|null $remember_token
 * @property bool $persist Indicate if record is deletable.
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserLog[] $userLogs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserPermission[] $userPermissions
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePersist($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'persist' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get table name with static call
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'users';
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
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
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
     * @return null|string
     */
    public function getLastLoginIp(): ?string
    {
        return $this->last_login_ip;
    }

    /**
     * @param null|string $last_login_ip
     */
    public function setLastLoginIp(?string $last_login_ip): void
    {
        $this->last_login_ip = $last_login_ip;
    }

    /**
     * @return null|string
     */
    public function getLastLoginAt(): ?string
    {
        return $this->last_login_at;
    }

    /**
     * @param null|string $last_login_at
     */
    public function setLastLoginAt(?string $last_login_at): void
    {
        $this->last_login_at = $last_login_at;
    }

    /**
     * @return bool
     */
    public function isPersist(): bool
    {
        return $this->persist;
    }

    /**
     * @param bool $persist
     */
    public function setPersist(bool $persist): void
    {
        $this->persist = $persist;
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
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany('App\Role', 'user_roles');
    }

    /**
     * User is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        $count = $this->roles()->where('name', '=', RoleEnum::ADMIN)->count();
        return $count > 0;
    }

    /**
     * User's role permission
     *
     * @param string $module
     * @param string $permission
     * @return bool
     */
    public function isRolePermitted(string $module, string $permission): bool
    {
        $count = RolePermission::join(
            'user_roles',
            RolePermission::getTableName() . '.role_id',
            '=',
            'user_roles.role_id'
        )->where('user_roles.user_id', '=', $this->getId())
            ->where(RolePermission::getTableName() . '.module', '=', $module)
            ->where(RolePermission::getTableName() . '.' . $permission, '=', 1)
            ->count();
        return $count > 0;
    }

    /**
     * @return HasMany
     */
    public function userPermissions(): HasMany
    {
        return $this->hasMany('App\UserPermission');
    }

    /**
     * User's permission, if userPermission is null, rule will follow rolePermission
     *
     * @param string $module
     * @param string $permission
     * @return bool
     */
    public function isUserPermitted(string $module, string $permission): bool
    {
        /* @var UserPermission $userPermission */
        $userPermission = $this->userPermissions()
            ->where(UserPermission::getTableName() . '.module', '=', $module)
            ->first();

        if (!is_null($userPermission)) {
            if ($userPermission->isActive() === true) {
                switch ($permission) {
                    case RolePermissionEnum::CAN_INSERT:
                        return $userPermission->isCanInsert();
                        break;
                    case RolePermissionEnum::CAN_UPDATE:
                        return $userPermission->isCanUpdate();
                        break;
                    case RolePermissionEnum::CAN_VIEW:
                        return $userPermission->isCanView();
                        break;
                    case RolePermissionEnum::CAN_DELETE:
                        return $userPermission->isCanDelete();
                        break;
                    default:
                        return false;
                }
            }
            return false;
        }

        return $this->isRolePermitted($module, $permission);
    }

    /**
     * @return HasMany
     */
    public function userLogs(): HasMany
    {
        return $this->hasMany('App\UserLog');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        dd(12);
        // $this->notify(new ResetPasswordNotification($token));
    }
}
