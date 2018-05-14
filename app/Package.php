<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * App\Package
 *
 * @property int $id
 * @property int $currency_id
 * @property string $currency_code
 * @property string $currency_symbol
 * @property string $currency_format
 * @property string $currency_exchange_rate
 * @property string $package_type
 * @property float $price
 * @property bool $is_active
 * @property string|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Package whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Package whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Package whereCurrencyExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Package whereCurrencyFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Package whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Package whereCurrencySymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Package whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Package whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Package wherePackageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Package wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Package whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Package extends Model
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
        return 'packages';
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
    public function getCurrencyId(): int
    {
        return $this->currency_id;
    }

    /**
     * @param int $currency_id
     */
    public function setCurrencyId(int $currency_id): void
    {
        $this->currency_id = $currency_id;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currency_code;
    }

    /**
     * @param string $currency_code
     */
    public function setCurrencyCode(string $currency_code): void
    {
        $this->currency_code = $currency_code;
    }

    /**
     * @return string
     */
    public function getCurrencySymbol(): string
    {
        return $this->currency_symbol;
    }

    /**
     * @param string $currency_symbol
     */
    public function setCurrencySymbol(string $currency_symbol): void
    {
        $this->currency_symbol = $currency_symbol;
    }

    /**
     * @return string
     */
    public function getCurrencyFormat(): string
    {
        return $this->currency_format;
    }

    /**
     * @param string $currency_format
     */
    public function setCurrencyFormat(string $currency_format): void
    {
        $this->currency_format = $currency_format;
    }

    /**
     * @return string
     */
    public function getCurrencyExchangeRate(): string
    {
        return $this->currency_exchange_rate;
    }

    /**
     * @param string $currency_exchange_rate
     */
    public function setCurrencyExchangeRate(string $currency_exchange_rate): void
    {
        $this->currency_exchange_rate = $currency_exchange_rate;
    }

    /**
     * @return string
     */
    public function getPackageType(): string
    {
        return $this->package_type;
    }

    /**
     * @param string $package_type
     */
    public function setPackageType(string $package_type): void
    {
        $this->package_type = $package_type;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
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
     * @param string $lang
     * @return HasOne
     */
    public function packageTranslation(string $lang = ''): HasOne
    {
        if (empty($lang)) {
            $lang = app('Language')->getId();
        }

        return $this->hasOne('App\PackageTranslation', 'package_id', 'id')
            ->where('language_id', $lang);
    }

    /**
     * Get friendly url
     *
     * @return MorphMany
     */
    public function friendlyUrl(): MorphMany
    {
        return $this->morphMany('App\FriendlyUrl', 'name', 'module', 'fkid');
    }
}
