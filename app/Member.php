<?php

namespace App;

use App\Notifications\Auth\ResetPassword;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * App\Member
 *
 * @property int                                                                                                            $id
 * @property string                                                                                                         $name
 * @property \Carbon\Carbon|null                                                                                            $dob
 * @property string|null                                                                                                    $mobile
 * @property string                                                                                                         $email
 * @property string                                                                                                         $password
 * @property int|null                                                                                                       $added_by
 * @property string|null                                                                                                    $last_login_ip
 * @property \Carbon\Carbon|null                                                                                            $last_login_at
 * @property string|null                                                                                                    $remember_token
 * @property bool                                                                                                           $is_active
 * @property string|null                                                                                                    $deleted_at
 * @property \Carbon\Carbon|null                                                                                            $created_at
 * @property \Carbon\Carbon|null                                                                                            $updated_at
 * @property-read \App\User|null                                                                                            $addedBy
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Member onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereLastLoginIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Member withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Member withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Address[]                                                   $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\MemberLog[]                                                 $memberLogs
 * @property-read \App\Membership                                                                                           $membership
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Membership[]                                                $memberships
 */
class Member extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'mobile', 'dob', 'password', 'is_active'
    // ];
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $dates = [
        'dob', 'last_login_at'
    ];

    /**
     * Get table name with static call
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'members';
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
     * @return \Carbon\Carbon|null
     */
    public function getDob(): ?\Carbon\Carbon
    {
        return $this->dob;
    }

    /**
     * @param \Carbon\Carbon|null $dob
     */
    public function setDob(?\Carbon\Carbon $dob): void
    {
        $this->dob = $dob;
    }

    /**
     * @return null|string
     */
    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    /**
     * @param null|string $mobile
     */
    public function setMobile(?string $mobile): void
    {
        $this->mobile = $mobile;
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
     * @return int|null
     */
    public function getAddedBy(): ?int
    {
        return $this->added_by;
    }

    /**
     * @param int|null $added_by
     */
    public function setAddedBy(?int $added_by): void
    {
        $this->added_by = $added_by;
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
     * @return \Carbon\Carbon|null
     */
    public function getLastLoginAt(): ?\Carbon\Carbon
    {
        return $this->last_login_at;
    }

    /**
     * @param \Carbon\Carbon|null $last_login_at
     */
    public function setLastLoginAt(?\Carbon\Carbon $last_login_at): void
    {
        $this->last_login_at = $last_login_at;
    }

    /**
     * @return null|string
     */
    public function getRememberToken(): ?string
    {
        return $this->remember_token;
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
     * @return null|string
     */
    public function getDeletedAt(): ?string
    {
        return $this->deleted_at;
    }

    /**
     * @param null|string $deleted_at
     */
    public function setDeletedAt(?string $deleted_at): void
    {
        $this->deleted_at = $deleted_at;
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
     * @return BelongsTo
     */
    public function addedBy(): BelongsTo
    {
        return $this->belongsTo('App\User', 'added_by');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    /**
     * Get address
     *
     * @return MorphMany
     */
    public function address(): MorphMany
    {
        return $this->morphMany('App\Address', 'name', 'module', 'fkid');
    }

    /**
     * Current membership of this member
     *
     * @return Membership|HasOne
     */
    public function membership(): HasOne
    {
        return $this->hasOne('App\Membership', 'member_id', 'id')
            ->where('is_active', '=', true)
            ->orderBy('id', 'desc');
    }

    /**
     * All previous memberships record
     *
     * @return HasMany
     */
    public function memberships(): HasMany
    {
        return $this->hasMany('App\Membership', 'member_id', 'id');
    }

    /**
     * @return Package
     */
    public function allowPackageToViewCourse(): Package
    {
        $membership = $this->membership()->first();
        $package = Package::wherePackageType(Package::FREE)->first();
        if (!$membership->isExpired()) {
            $package = $membership->package()->first();
        }
        return $package;
    }

    /**
     * @return HasMany
     */
    public function memberLogs(): HasMany
    {
        return $this->hasMany('App\MemberLog');
    }

    /**
     * @return HasMany
     */
    public function invoices(): HasMany
    {
        return $this->hasMany('App\Invoice');
    }
}
