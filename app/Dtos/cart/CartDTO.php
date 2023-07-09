<?php

namespace App\Dtos\cart;

use App\Models\Customer;

class CartDTO
{
    private Customer $customer;
    private int $total;
    private array $cartItems;

    /**
     * @param Customer $customer
     * @param int $total
     * @param array $cartItems
     */
    public function __construct(Customer $customer, int $total, array $cartItems)
    {
        $this->customer = $customer;
        $this->total = $total;
        $this->cartItems = $cartItems;
    }


    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    /**
     * @return array
     */
    public function getCartItems(): array
    {
        return $this->cartItems;
    }

    /**
     * @param array $cartItems
     */
    public function setCartItems(array $cartItems): void
    {
        $this->cartItems = $cartItems;
    }

}
