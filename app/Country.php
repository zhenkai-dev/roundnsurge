<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Country
 *
 * @property int    $id
 * @property string $name
 * @property string $iso_code_2
 * @property string $iso_code_3
 * @property bool   $is_active
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereIsoCode2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereIsoCode3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Country whereName($value)
 * @mixin \Eloquent
 */
class Country extends Model
{
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get table name with static call
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'countries';
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
    public function getIsoCode2(): string
    {
        return $this->iso_code_2;
    }

    /**
     * @param string $iso_code_2
     */
    public function setIsoCode2(string $iso_code_2): void
    {
        $this->iso_code_2 = $iso_code_2;
    }

    /**
     * @return string
     */
    public function getIsoCode3(): string
    {
        return $this->iso_code_3;
    }

    /**
     * @param string $iso_code_3
     */
    public function setIsoCode3(string $iso_code_3): void
    {
        $this->iso_code_3 = $iso_code_3;
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
     * @return Builder
     */
    public static function dropdown(): Builder
    {
        return self::whereIsActive(true)
            ->orderBy('name', 'asc');
    }
}
