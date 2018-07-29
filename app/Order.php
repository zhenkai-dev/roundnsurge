<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Order
 *
 * @mixin \Eloquent
 * @property int                 $id
 * @property int|null            $member_id
 * @property int                 $currency_id
 * @property string              $order_no
 * @property string              $email
 * @property string              $username
 * @property string              $currency_code
 * @property string              $currency_symbol
 * @property string              $currency_format
 * @property string              $currency_exchange_rate
 * @property float               $amount
 * @property string              $item_name
 * @property string              $order_type
 * @property string|null         $order_details
 * @property bool                $paid
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCurrencyExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCurrencyFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCurrencySymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereOrderDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereOrderType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUsername($value)
 */
class Order extends Model
{
    const REGISTER_MEMBERSHIP = 'register_membership';

    const RENEW_MEMBERSHIP = 'renew_membership';

    const UPGRADE_MEMBERSHIP = 'upgrade_membership';

    protected $casts = [
        'paid' => 'boolean',
        'order_details' => 'array'
    ];

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
     * @return int|null
     */
    public function getMemberId(): ?int
    {
        return $this->member_id;
    }

    /**
     * @param int|null $member_id
     */
    public function setMemberId(?int $member_id): void
    {
        $this->member_id = $member_id;
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
    public function getOrderNo(): string
    {
        return $this->order_no;
    }

    /**
     * @param string $order_no
     */
    public function setOrderNo(string $order_no): void
    {
        $this->order_no = $order_no;
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
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getItemName(): string
    {
        return $this->item_name;
    }

    /**
     * @param string $item_name
     */
    public function setItemName(string $item_name): void
    {
        $this->item_name = $item_name;
    }

    /**
     * @return string
     */
    public function getOrderType(): string
    {
        return $this->order_type;
    }

    /**
     * @param string $order_type
     */
    public function setOrderType(string $order_type): void
    {
        $this->order_type = $order_type;
    }

    /**
     * @return string
     */
    public function getOrderDetails(): ?string
    {
        return $this->order_details;
    }

    /**
     * @param string $order_details
     */
    public function setOrderDetails(?string $order_details): void
    {
        $this->order_details = $order_details;
    }

    /**
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->paid;
    }

    /**
     * @param bool $paid
     */
    public function setPaid(bool $paid): void
    {
        $this->paid = $paid;
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
