<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\InvoiceItem
 *
 * @property int $id
 * @property int $invoice_id
 * @property int $fkid
 * @property string $module
 * @property string $item_name
 * @property float $amount
 * @property int $quantity
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereFkid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InvoiceItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InvoiceItem extends Model
{
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
    public function getInvoiceId(): int
    {
        return $this->invoice_id;
    }

    /**
     * @param int $invoice_id
     */
    public function setInvoiceId(int $invoice_id): void
    {
        $this->invoice_id = $invoice_id;
    }

    /**
     * @return int
     */
    public function getFkid(): int
    {
        return $this->fkid;
    }

    /**
     * @param int $fkid
     */
    public function setFkid(int $fkid): void
    {
        $this->fkid = $fkid;
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
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
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
