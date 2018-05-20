<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * \App\MemberLog
 *
 * @property int $id
 * @property int $member_id
 * @property string|null $route_name
 * @property float $query_time
 * @property string|null $statement
 * @property string|null $binding
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberLog whereBinding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberLog whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberLog whereQueryTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberLog whereRouteName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberLog whereStatement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MemberLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MemberLog extends Model
{
    /**
     * Get table name with static call
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'user_logs';
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
     * @return null|string
     */
    public function getRouteName(): ?string
    {
        return $this->route_name;
    }

    /**
     * @param null|string $route_name
     */
    public function setRouteName(?string $route_name): void
    {
        $this->route_name = $route_name;
    }

    /**
     * @return float
     */
    public function getQueryTime(): float
    {
        return $this->query_time;
    }

    /**
     * @param float $query_time
     */
    public function setQueryTime(float $query_time): void
    {
        $this->query_time = $query_time;
    }

    /**
     * @return null|string
     */
    public function getStatement(): ?string
    {
        return $this->statement;
    }

    /**
     * @param null|string $statement
     */
    public function setStatement(?string $statement): void
    {
        $this->statement = $statement;
    }

    /**
     * @return null|string
     */
    public function getBinding(): ?string
    {
        return $this->binding;
    }

    /**
     * @param null|string $binding
     */
    public function setBinding(?string $binding): void
    {
        $this->binding = $binding;
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
