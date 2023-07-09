<?php

namespace App\Dtos\cartItem;

use App\Dtos\AbstractDTO;

class CartItemDto extends AbstractDTO
{
    private string $name;
    private string $image;
    private string $price;
    private int $qty;
    private array $option;

    /**
     * @param string $name
     * @param string $image
     * @param string $price
     * @param int $qty
     * @param $option
     */
    public function __construct(int $id = 0, string $name = '', string $image = '', string $price = '', int $qty = 0,array $option = null)
    {
        parent::__construct($id);
        $this->name = $name;
        $this->image = $image;
        $this->price = $price;
        $this->qty = $qty;
        $this->option = $option;
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
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function getQty(): int
    {
        return $this->qty;
    }

    /**
     * @param int $qty
     */
    public function setQty(int $qty): void
    {
        $this->qty = $qty;
    }

    /**
     * @return array
     */
    public function getOption($key = '')
    {
        return empty($key) ? $this->option : $this->option[$key];
    }

    /**
     * @param array $option
     */
    public function setOption(array $option): void
    {
        $this->option = $option;
    }

}
