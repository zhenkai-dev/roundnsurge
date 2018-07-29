<?php
/**
 * Created by PhpStorm.
 * User: Kit Loong
 * Date: 28/7/2018
 * Time: 12:19 PM
 */

namespace App\Dto;

class OrderDetailDto
{
    /**
     * @var int
     */
    private $itemId;

    /**
     * @var string
     */
    private $itemModule;

    /**
     * @var string
     */
    private $itemName;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->itemId;
    }

    /**
     * @param int $itemId
     */
    public function setItemId(int $itemId): void
    {
        $this->itemId = $itemId;
    }

    /**
     * @return string
     */
    public function getItemModule(): string
    {
        return $this->itemModule;
    }

    /**
     * @param string $itemModule
     */
    public function setItemModule(string $itemModule): void
    {
        $this->itemModule = $itemModule;
    }

    /**
     * @return string
     */
    public function getItemName(): string
    {
        return $this->itemName;
    }

    /**
     * @param string $itemName
     */
    public function setItemName(string $itemName): void
    {
        $this->itemName = $itemName;
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

    public function toArray(): array
    {
        return [
            'item_id' => $this->getItemId(),
            'item_module' => $this->getItemModule(),
            'item_name' => $this->getItemName(),
            'amount' => $this->getAmount(),
            'quantity' => $this->getQuantity()
        ];
    }

    public static function arrayToObject(array $array): OrderDetailDto
    {
        $object = new OrderDetailDto();
        $object->setItemId((int)$array['item_id']);
        $object->setItemModule((string)$array['item_module']);
        $object->setItemName((string)$array['item_name']);
        $object->setAmount((float)$array['amount']);
        $object->setQuantity((int)$array['quantity']);
        return $object;
    }
}