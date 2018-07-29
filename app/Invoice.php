<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * App\Invoice
 *
 * @property int                 $id
 * @property int|null            $member_id
 * @property string|null         $prefix
 * @property int                 $invoice_no
 * @property string              $auth_key
 * @property string              $billing_name
 * @property string              $billing_email
 * @property string|null         $billing_contact
 * @property string|null         $billing_address1
 * @property string|null         $billing_address2
 * @property string|null         $billing_postcode
 * @property string|null         $billing_city
 * @property string|null         $billing_state
 * @property int|null            $billing_country_id
 * @property int                 $currency_id
 * @property string              $currency_code
 * @property string              $currency_symbol
 * @property string              $currency_format
 * @property string              $currency_exchange_rate
 * @property float               $amount
 * @property string              $payment_method
 * @property bool                $paid
 * @property float               $paid_amount
 * @property \Carbon\Carbon|null $paid_date
 * @property string              $invoice_status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereAuthKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereBillingAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereBillingAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereBillingCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereBillingContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereBillingEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereBillingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereBillingPostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereBillingState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCurrencyExchangeRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCurrencyFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCurrencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCurrencySymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereInvoiceNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereInvoiceStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice wherePaidDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    protected $casts = [
        'paid' => 'boolean',
    ];

    protected $dates = [
        'paid_date'
    ];

    const PAY_METHOD_PAYPAL = 'paypal';

    const STATUS_PAID = 'paid';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_PENDING = 'pending';

    /**
     * Get table name with static call
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'invoices';
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
     * @return null|string
     */
    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    /**
     * @param null|string $prefix
     */
    public function setPrefix(?string $prefix): void
    {
        $this->prefix = $prefix;
    }

    /**
     * @return int
     */
    public function getInvoiceNo(): int
    {
        return $this->invoice_no;
    }

    /**
     * @param int $invoice_no
     */
    public function setInvoiceNo(int $invoice_no): void
    {
        $this->invoice_no = $invoice_no;
    }

    /**
     * @return string
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * @param string $auth_key
     */
    public function setAuthKey(string $auth_key): void
    {
        $this->auth_key = $auth_key;
    }

    /**
     * @return string
     */
    public function getBillingName(): string
    {
        return $this->billing_name;
    }

    /**
     * @param string $billing_name
     */
    public function setBillingName(string $billing_name): void
    {
        $this->billing_name = $billing_name;
    }

    /**
     * @return string
     */
    public function getBillingEmail(): string
    {
        return $this->billing_email;
    }

    /**
     * @param string $billing_email
     */
    public function setBillingEmail(string $billing_email): void
    {
        $this->billing_email = $billing_email;
    }

    /**
     * @return null|string
     */
    public function getBillingContact(): ?string
    {
        return $this->billing_contact;
    }

    /**
     * @param null|string $billing_contact
     */
    public function setBillingContact(?string $billing_contact): void
    {
        $this->billing_contact = $billing_contact;
    }

    /**
     * @return null|string
     */
    public function getBillingAddress1(): ?string
    {
        return $this->billing_address1;
    }

    /**
     * @param null|string $billing_address1
     */
    public function setBillingAddress1(?string $billing_address1): void
    {
        $this->billing_address1 = $billing_address1;
    }

    /**
     * @return null|string
     */
    public function getBillingAddress2(): ?string
    {
        return $this->billing_address2;
    }

    /**
     * @param null|string $billing_address2
     */
    public function setBillingAddress2(?string $billing_address2): void
    {
        $this->billing_address2 = $billing_address2;
    }

    /**
     * @return null|string
     */
    public function getBillingPostcode(): ?string
    {
        return $this->billing_postcode;
    }

    /**
     * @param null|string $billing_postcode
     */
    public function setBillingPostcode(?string $billing_postcode): void
    {
        $this->billing_postcode = $billing_postcode;
    }

    /**
     * @return null|string
     */
    public function getBillingCity(): ?string
    {
        return $this->billing_city;
    }

    /**
     * @param null|string $billing_city
     */
    public function setBillingCity(?string $billing_city): void
    {
        $this->billing_city = $billing_city;
    }

    /**
     * @return null|string
     */
    public function getBillingState(): ?string
    {
        return $this->billing_state;
    }

    /**
     * @param null|string $billing_state
     */
    public function setBillingState(?string $billing_state): void
    {
        $this->billing_state = $billing_state;
    }

    /**
     * @return int|null
     */
    public function getBillingCountryId(): ?int
    {
        return $this->billing_country_id;
    }

    /**
     * @param int|null $billing_country_id
     */
    public function setBillingCountryId(?int $billing_country_id): void
    {
        $this->billing_country_id = $billing_country_id;
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
    public function getPaymentMethod(): string
    {
        return $this->payment_method;
    }

    /**
     * @param string $payment_method
     */
    public function setPaymentMethod(string $payment_method): void
    {
        $this->payment_method = $payment_method;
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
     * @return float
     */
    public function getPaidAmount(): float
    {
        return $this->paid_amount;
    }

    /**
     * @param float $paid_amount
     */
    public function setPaidAmount(float $paid_amount): void
    {
        $this->paid_amount = $paid_amount;
    }

    /**
     * @return \Carbon\Carbon|null
     */
    public function getPaidDate(): ?\Carbon\Carbon
    {
        return $this->paid_date;
    }

    /**
     * @param \Carbon\Carbon|null $paid_date
     */
    public function setPaidDate(?\Carbon\Carbon $paid_date): void
    {
        $this->paid_date = $paid_date;
    }

    /**
     * @return string
     */
    public function getInvoiceStatus(): string
    {
        return $this->invoice_status;
    }

    /**
     * @param string $invoice_status
     */
    public function setInvoiceStatus(string $invoice_status): void
    {
        $this->invoice_status = $invoice_status;
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
     * @return HasMany
     */
    public function invoiceItems(): HasMany
    {
        return $this->hasMany('App\InvoiceItem');
    }

    /**
     * @return string
     */
    public function formatInvoiceNo(): string
    {
        return $this->getPrefix() . $this->getInvoiceNo();
    }

    public function invoiceStatusToText(): string
    {
        switch ($this->invoice_status) {
            case self::STATUS_PAID:
                return __('invoice.invoice_status_paid');
                break;
            case self::STATUS_PENDING:
                return __('invoice.invoice_status_pending');
                break;
            case self::STATUS_CANCELLED:
                return __('invoice.invoice_status_cancelled');
                break;
        }
        return $this->invoice_status;
    }

    /**
     * @return BelongsTo
     */
    public function member(): BelongsTo
    {
        return $this->belongsTo('App\Member');
    }
}
