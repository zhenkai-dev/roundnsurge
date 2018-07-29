<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Transaction
 *
 * @property int $id
 * @property int $order_id
 * @property string $payment_method
 * @property string $response
 * @property \Carbon\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transaction whereResponse($value)
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    /**
     * Get table name with static call
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return 'transactions';
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
    public function getOrderId(): int
    {
        return $this->order_id;
    }

    /**
     * @param int $order_id
     */
    public function setOrderId(int $order_id): void
    {
        $this->order_id = $order_id;
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
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * @param string $response
     */
    public function setResponse(string $response): void
    {
        $this->response = $response;
    }

    /**
     * @return \Carbon\Carbon
     */
    public function getCreatedAt(): \Carbon\Carbon
    {
        return $this->created_at;
    }
}
