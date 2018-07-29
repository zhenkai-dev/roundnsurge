<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * \App\Membership
 *
 * @property int                 $id
 * @property int                 $member_id
 * @property int                 $package_id
 * @property \Carbon\Carbon|null         $expiry_date
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property bool                $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereIsActive($value)
 * @property-read \App\Member $member
 * @property-read \App\Package $package
 */
class Membership extends Model
{
    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $dates = [
        'expiry_date'
    ];

    /**
     * Get table name with static call
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'memberships';
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
    public function getMemberId(): int
    {
        return $this->member_id;
    }

    /**
     * @param int $member_id
     */
    public function setMemberId(int $member_id): void
    {
        $this->member_id = $member_id;
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
     * @return null|string
     */
    public function getExpiryDate(): ?\Carbon\Carbon
    {
        return $this->expiry_date;
    }

    /**
     * @param null|string $expiry_date
     */
    public function setExpiryDate(?\Carbon\Carbon $expiry_date): void
    {
        $this->expiry_date = $expiry_date;
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
     * @return BelongsTo
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo('App\Member', 'member_id');
    }

    /**
     * @return BelongsTo
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo('App\Package', 'package_id');
    }

    public function isExpired(): bool
    {
        if ($this->getExpiryDate() === null) {
            return false;
        }

        return $this->getExpiryDate() < Carbon::today();
    }
}
